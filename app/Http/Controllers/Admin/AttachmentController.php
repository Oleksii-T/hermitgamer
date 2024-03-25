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
