<?php

namespace App\Traits;

use App\Models\Attachment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAttachments
{
    /**
     * Attach the file to the model.
     * We can attach multiple or one file.
     * If we attach multiple one file, then previous file is deleted.
     * We may attach Illuminate\Http\UploadedFile or array.
     * Array should contain keys: file, alt, name. It a part of rich-image-input feature.
     */
    public function addAttachment($attachment, string $group=null)
    {
        if (!$attachment) {
            return [];
        }

        $group ??= 'files';
        $isMultiple = is_array($attachment) && !($attachment['alt']??false) && !($attachment['name']??false);
        $savedAttachments = [];

        if($isMultiple) {
            $attachments = $attachment;

            $existings = $this->$group()->get();
            $existingIds = $existings->pluck('id')->toArray();
            $keep = array_column($attachments, 'id');
            $remove = array_diff($existingIds, $keep);
            foreach ($remove as $removeId) {
                $existings->where('id', $removeId)->first()->delete();
            }
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

            // just update alt and title in existing attachment
            if (!$simpleAttachment && !$uploadedFile && $attachmentId) {
                $m = Attachment::find($attachmentId);
                $m->update([
                    'alt' => $attachment['alt'],
                    'title' => $attachment['title'],
                ]);
                $savedAttachments[] = $m;
                continue;
            }

            // prepare meta data for creating new attachment
            $type = $this->determineType($uploadedFile->extension());
            $disk = Attachment::disk($type);
            $og_name = Attachment::makeUniqueName($uploadedFile->getClientOriginalName(), $disk);

            $path = $uploadedFile->storeAs('', $og_name, $disk);
            if ($simpleAttachment) {
                $alt = readable(strstr($og_name, '.', true));
                $title = $alt;
            } else {
                $alt = $attachment['alt'];
                $title = $attachment['title'];
            }

            // create new attachment
            $savedAttachments[] = $this->$group()->create([
                'name' => $path,
                'original_name' => $og_name,
                'type' => $type,
                'alt' => $alt,
                'title' => $title,
                'group' => $group,
                'size' => $uploadedFile->getSize()
            ]);
        }

        return $savedAttachments;
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
