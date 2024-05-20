<?php

namespace App\Traits;

use App\Models\Attachment;
use App\Models\Attachmentable;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait HasAttachments
{
    /**
     * Attach the file to the model.
     * We can attach multiple or one file.
     * If we attach single one file, then previous attachment is detached automaticaly.
     * We may attach Illuminate\Http\UploadedFile or array.
     * Array should contain key 'file' or key 'id'.
     */
    public function addAttachment($attachment, string $group)
    {
        dlog("HasAttachments@addAttachment $group | $this->id | " . self::class ); //! LOG

        if (!$attachment) {
            dlog(" empty"); //! LOG
            return [];
        }

        $attachment = $this->transform($attachment);
        $isMultiple = !($attachment['id']??false) && !($attachment['file']??false);
        $savedAttachments = [];
        $existed = Attachmentable::getByModel($this, $group, false);

        if($isMultiple) {
            dlog(" is mult"); //! LOG
            $attachments = $attachment;
            $existed->whereNotIn('attachment_id', array_column($attachments, 'id'))->delete();
        } else {
            dlog(" is one"); //! LOG
            $attachments = [$attachment];

            if (!$attachment['id'] || $attachment['id_old'] != $attachment['id']) {
                $existed->delete();
            }
        }

        foreach ($attachments as $attachment) {
            $attachmentModel = isset($attachment['id']) ? Attachment::find($attachment['id']) : null;
            $attachmentIdOld = $attachment['id_old']??null;

            if ($attachmentModel && $attachmentModel->id == $attachmentIdOld) {
                $savedAttachments[] = $attachmentModel;
                dlog("  same id"); //! LOG
                continue;
            }

            if ($attachmentModel && $attachmentModel->id != $attachmentIdOld) {
                Attachmentable::create([
                    'attachment_id' => $attachmentModel->id,
                    'attachmentable_id' => $this->id,
                    'attachmentable_type' => get_class($this),
                    'group' => $group,
                ]);
                $savedAttachments[] = $attachmentModel;
                dlog("  new id"); //! LOG
                continue;
            }

            $uploadedFile = $attachment['file']??null;
            $type = $this->determineType($uploadedFile->extension());
            $disk = Attachment::disk($type);
            $og_name = Attachment::makeUniqueName($uploadedFile->getClientOriginalName(), $disk);
            $attachment['alt'] ??= readable(strstr($og_name, '.', true));
            $attachment['title'] ??= $attachment['alt'];
            $path = $uploadedFile->storeAs('', $og_name, $disk);

            $attachmentModel = Attachment::create([
                'name' => $path,
                'original_name' => $og_name,
                'type' => $type,
                'alt' => $attachment['alt'],
                'title' => $attachment['title'],
                'size' => $uploadedFile->getSize()
            ]);
            Attachmentable::create([
                'attachment_id' => $attachmentModel->id,
                'attachmentable_id' => $this->id,
                'attachmentable_type' => get_class($this),
                'group' => $group,
            ]);
            $savedAttachments[] = $attachmentModel;
            dlog("  new file"); //! LOG
        }

        return $savedAttachments;
    }

    private function transform($attachment)
    {
        if (!is_array($attachment)) {
            // it is one attachment as UploadedFile instance
            return ['file' => $attachment];
        }

        if (($attachment['id']??false) || ($attachment['file']??false)) {
            // it is one attachment in array form
            return $attachment;
        }

        if (($attachment[0]['id']??false) || ($attachment[0]['file']??false)) {
            // it is few attachments in array form
            return $attachment;
        }

        // it is few attachments as UploadedFile instances
        $result = [];
        foreach ($attachment as $a) {
            $result[] = ['file' => $a];
        }
        return $result;
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
}
