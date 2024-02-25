<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use App\Models\Attachment;

trait HasAttachments
{
    public function addAttachment($attachment, string $group=null)
    {
        if (!$attachment) {
            return;
        }

        $group ??= 'files';

        if(is_array($attachment)) {
            $attachments = $attachment;
        } else {
            $attachments = [$attachment];
            $this->$group()->delete();
        }

        foreach ($attachments as $attachment) {
            $type = $this->determineType($attachment->extension());
            $disk = Attachment::disk($type);
            $og_name = $attachment->getClientOriginalName();
            $path = $attachment->storeAs('', $og_name, $disk);
            $alt = readable(strstr($og_name, '.', true));

            $this->$group()->create([
                'name' => $path,
                'original_name' => $attachment->getClientOriginalName(),
                'type' => $type,
                'alt' => $alt,
                'title' => $alt,
                'group' => $group,
                'size' => $attachment->getSize()
            ]);
        }
    }

    private function determineType($ext)
    {
        if (in_array($ext, ['jpeg','gif','png', 'jpg', 'webp'])) {
            $type = 'image';
        } else if (in_array($ext, ['doc', 'docx', 'pdf'])) {
            $type = 'document';
        } else if (in_array($ext, ['mov','mp4','avi','ogg','wmv','webm','mkv'])) {
            $type = 'video';
        } else {
            $type = 'file';
        }

        return $type;
    }

    public function purgeFiles($group)
    {
        $this->$group()->delete();
    }
}
