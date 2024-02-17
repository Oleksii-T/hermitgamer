<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Traits\HasAttachments;

class BlockItem extends Model
{
    use HasAttachments;

    protected $fillable = [
        'block_id',
        'type',
        'order',
        'value',
    ];

    protected $appends = [
        'value'
    ];

    protected $hidden = [
        'translations',
    ];

    const TYPES = [
        'title',
        'text',
        'image',
        'video',
        'slider'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            // foreach (self::ATTACHMENTS as $group) {
            //     $model->purgeFiles($group);
            // }
            $model->purgeTranslations();
        });
    }

    public function files()
    {
        return $this->morphOne(Attachment::class, 'attachmentable');
    }

    public function file()
    {
        return $this->files()->first();
    }

    public function value(): Attribute
    {
        return new Attribute(
            get: function () {
                if (in_array($this->type, ['title', 'text'])) {
                    return $this->translatedFull($this->type, true);
                }
                if (in_array($this->type, ['image', 'video'])) {
                    $file = $this->file();
                    return [
                        'id' => $file->id,
                        'original_name' => $file->original_name,
                        'url' => $file->url
                    ];
                }
            }
        );
    }
}
