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
        $isMultiple = is_array($attachment) && !($attachment['alt']??false) && !($attachment['name']??false);

        if($isMultiple) {
            $attachments = $attachment;
        } else {
            $attachments = [$attachment];
            $deleteOldAttachment = !is_array($attachment) || (is_array($attachment) && ($attachment['file']??false));

            if ($deleteOldAttachment) {
                $this->$group()->delete();
            }
        }

        foreach ($attachments as $attachment) {
            $aBackUp = $attachment;
            $simpleAttachment = $attachment instanceof UploadedFile;
            $uploadedFile = $simpleAttachment ? $attachment : ($attachment['file']??null);
            $attachmentId = $simpleAttachment ? null : ($attachment['id']??null);

            // dump($attachment);

            // just update alt and title in existing attachment
            if (!$simpleAttachment && !$uploadedFile && $attachmentId) {
                Attachment::find($attachmentId)->update([
                    'alt' => $attachment['alt'],
                    'title' => $attachment['title'],
                ]);
                return;
            }


            // prepare meta data for creating new attachment
            $type = $this->determineType($uploadedFile->extension());
            $disk = Attachment::disk($type);
            $og_name = $uploadedFile->getClientOriginalName();
            $path = $uploadedFile->storeAs('', $og_name, $disk);
            if ($simpleAttachment) {
                // dump('is simple');
                $alt = readable(strstr($og_name, '.', true));
                $title = $alt;
            } else {
                // dump('is a array');
                $alt = $attachment['alt'];
                $title = $attachment['title'];
            }

            // dump($alt, $title);
            // dd('here');

            // create new attachment
            $this->$group()->create([
                'name' => $path,
                'original_name' => $uploadedFile->getClientOriginalName(),
                'type' => $type,
                'alt' => $alt,
                'title' => $title,
                'group' => $group,
                'size' => $uploadedFile->getSize()
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
