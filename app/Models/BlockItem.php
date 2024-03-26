<?php

namespace App\Models;

use App\Enums\BlockItemType;
use App\Traits\HasAttachments;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class BlockItem extends Model
{
    use HasAttachments;

    protected $fillable = [
        'block_id',
        'type',
        'order',
        'value',
    ];

    protected $casts = [
        'type' => BlockItemType::class,
    ];

    protected $hidden = [
        'translations',
    ];

    public function files()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function file()
    {
        return $this->files()->first();
    }

    public function value(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                $simpleValueTypes = BlockItemType::getSimpleTextTypes();
                $simpleFileTypes = BlockItemType::getSimpleFileTypes();
                $value = json_decode($value, true);

                if ($this->type == BlockItemType::IMAGE_TITLE) {
                    $file = $this->file();
                    return [
                        'title' => $value['title'],
                        'image' => [
                            'id' => $file->id,
                            'original_name' => $file->original_name,
                            'url' => $file->url
                        ]
                    ];
                }

                if ($this->type == BlockItemType::IMAGE_GALLERY) {
                    $files = [];
                    foreach ($this->files as $file) {
                        $files[] = [
                            'id' => $file->id,
                            'original_name' => $file->original_name,
                            'url' => $file->url
                        ];
                    }
                    return [
                        'images' => $files
                    ];
                }

                if (in_array($this->type->value, $simpleFileTypes)) {
                    $file = $this->file();
                    return [
                        'id' => $file->id,
                        'original_name' => $file->original_name,
                        'url' => $file->url
                    ];
                }

                return $value;
            },
        );
    }

    public function valueSimple(): Attribute
    {
        return new Attribute(
            get: function () {
                $value = $this->value;
                $simpleValueTypes = BlockItemType::getSimpleTextTypes();

                if (in_array( $this->type->value, $simpleValueTypes)) {
                    return $value['value'];
                }
                
                if ($this->type == BlockItemType::IMAGE_GALLERY) {
                    return $value['images'];
                }

                return $value;
            },
        );
    }
}
