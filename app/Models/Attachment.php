<?php

namespace App\Models;

use Illuminate\Support\Arr;
use Yajra\DataTables\DataTables;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attachment extends Model
{
    use HasFactory;
    // 1440 - full width

    // 1920x1080 = 1.7 OR 0.56

    /**
     * @var array
     */
	protected $fillable = [
        'name',
        'alt',
        'title',
        'group',
        'original_name',
        'type',
        'size',
        'attachmentable_id',
        'attachmentable_id_type'
    ];

    protected $appends = [
        'url'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $disk = self::disk($model->type);
            Storage::disk($disk)->delete($model->name);
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function attachmentable()
    {
        return $this->morphTo();
    }

    /**
     * @return string
     */
    public function getSize()
    {
        if ($this->size > 1000000) {
            return number_format($this->size / 1000000, 2) . ' MB';
        }
        if ($this->size > 1000) {
            return number_format($this->size / 1000, 2) . ' kB';
        }

        return $this->size . ' B';
    }

    public function url(): Attribute
    {
        return new Attribute(
            get: fn ($value) => Storage::disk(self::disk($this->type))->url($this->name),
        );
    }

    public static function disk($type)
    {
        return match ($type) {
            'video' => 'avideos',
            'image' => 'aimages',
            'document' => 'adocuments',
            default => 'attachments',
        };
    }

    public static function makeUniqueName($name, $disk)
    { 
        $i = 1;
        $ogName = $name;
        $nameParts = explode('.', $name);
        $extension = array_pop($nameParts);

        while (Storage::disk($disk)->exists($name)) {
            $name = implode('.', $nameParts) . "-$i.$extension";
            $i++;
        }

        return $name;
    }

    public static function dataTable($query)
    {
        return DataTables::of($query)
            ->editColumn('size', function ($model) {
                return $model->getSize() . " ($model->size)";
            })
            ->editColumn('created_at', function ($model) {
                return $model->created_at->format(env('ADMIN_DATETIME_FORMAT'));
            })
            ->addColumn('action', function ($model) {
                return view('components.admin.actions', [
                    'model' => $model,
                    'name' => 'attachments',
                    'actions' => ['edit']
                ])->render();
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public static function formatMultipleRichInputRequest($data)
    {
        $result = [];

        foreach ($data['title']??[] as $i => $title) {
            $id = Arr::get($data, "id.$i");
            $file = Arr::get($data, "file.$i");
            $alt = $data['alt'][$i];

            if (!$id && !$file) {
                continue;
            }

            $img = [
                'alt' => $alt,
                'title' => $title,
                'id' => $id,
                'file' => $file
            ];
        }

        return $result;
    }
}
