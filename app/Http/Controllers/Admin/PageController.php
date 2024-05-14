<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\PageBlock;
use Illuminate\Http\Request;
use App\Actions\GenerateSitemap;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Admin\PageRequest;

class PageController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.pages.index');
        }

        return Page::dataTable(Page::query());
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(PageRequest $request)
    {
        $input = $request->validated();
        Page::create($input);

        Page::getAllSlugs(true);
        GenerateSitemap::run();

        return $this->jsonSuccess('Page created successfully', [
            'redirect' => route('admin.pages.index')
        ]);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(PageRequest $request, Page $page)
    {
        $input = $request->validated();
        $page->update($input);

        Page::getAllSlugs(true);
        GenerateSitemap::run();

        return $this->jsonSuccess('Page updated successfully');
    }

    public function editBlocks(Page $page)
    {
        return view('admin.pages.editBlocks', compact('page'));
    }

    public function updateBlocks(Request $request, Page $page)
    {
        $disk = Storage::disk('pages');
        foreach ($request->blocks as $id => $block) {
            foreach ($block as $item_name => $item) {
                if ($item['type'] == 'dynamic') {
                    $tmp_item = ['blocks' => [], 'type' => 'dynamic'];
                    foreach ($item['blocks'] as $name => $tmp_block) {
                        foreach ($tmp_block['type'] as $number => $type) {
                            if ($type == 'video'){
                                $tmp_item['blocks'][$number][$name] = [
                                    'value' => $tmp_block['value'][$number],
                                    'src' => $tmp_block['src'][$number],
                                    'type' => $type
                                ];
                            }elseif ($type == 'image'){
                                $tmp_item['blocks'][$number][$name] = [
                                    'value' => isset($tmp_block['value'][$number])
                                        ? $disk->putFile("", $tmp_block['value'][$number])
                                        : $tmp_block['value_old'][$number],
                                    'type' => $type
                                ];
                            }else{
                                $tmp_item['blocks'][$number][$name] = [
                                    'value' => $tmp_block['value'][$number],
                                    'type' => $type
                                ];
                            }
                        }
                    }
                    $block[$item_name] = $tmp_item;
                } else if ($item['type'] == 'image') {
                    $block[$item_name]['value'] = isset($item['value'])
                        ? $disk->putFile("", $item['value'])
                        : $item['value_old'];
                }
            }

            PageBlock::findOrFail($id)->update([
                'data' => $block
            ]);
        }

        return $this->jsonSuccess('Page updated successfully', [
            'redirect' => route('admin.pages.edit', $page)
        ]);
    }

    public function destroy(Page $page)
    {
        if ($page->isStatic()) {
            return $this->jsonError('Can not delete static page', [], 200);
        }

        $page->delete();

        return $this->jsonSuccess('Page deleted successfully');
    }
}
