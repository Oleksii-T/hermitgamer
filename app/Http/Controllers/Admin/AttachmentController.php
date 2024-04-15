<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attachment;
use App\Http\Requests\Admin\AttachmentRequest;
use Illuminate\Support\Facades\Storage;


class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.attachments.index');
        }

        $attachments = Attachment::query();

        if ($request->type !== null) {
            $attachments->where('type', $request->type);
        }

        return Attachment::dataTable($attachments);
    }

    public function edit(Attachment $attachment)
    {
        return view('admin.attachments.edit', compact('attachment'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'image', 'max:5000']
        ]);

        $disk = 'aimages';
        $type = 'image';
        $file = $request->file;
        $og_name = Attachment::makeUniqueName($file->getClientOriginalName(), $disk);

        $path = $file->storeAs('', $og_name, $disk);
        $alt = readable(strstr($og_name, '.', true));
        $title = $alt;

        // create new attachment
        $a = Attachment::create([
            'name' => $path,
            'original_name' => $og_name,
            'type' => $type,
            'alt' => $alt,
            'title' => $title,
            'size' => $file->getSize()
        ]);

        return $this->jsonSuccess('', [
            'url' => $a->url
        ]);
    }

    public function update(AttachmentRequest $request, Attachment $attachment)
    {
        $input = $request->validated();

        $attachment->update($input);

        return $this->jsonSuccess('Attachment updated successfully');
    }

    public function download(Request $request, Attachment $attachment)
    {
        $disk = Attachment::disk($attachment->type);

        return Storage::disk($disk)->download($attachment->name);
    }

    public function destroy(Request $request, Attachment $attachment)
    {
        $attachment->delete();

        return $this->jsonSuccess('Blog updated successfully');
    }
}
