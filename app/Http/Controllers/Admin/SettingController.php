<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Services\TwitterService;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $settings = $request->s;
        $editableSettings = Setting::EDATABLE_SETTINGS;

        foreach ($request->s as $key => $value) {
            if (in_array($key, $editableSettings)) {
                Setting::set($key, $value);
            }
        }

        return $this->jsonSuccess(null, 'Settings udpated successfully');
    }
}
