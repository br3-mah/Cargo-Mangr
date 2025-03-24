<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\GeneralSettings;
use App\Http\Requests\GeneralRequest;
use App\Models\Settings;

class SettingsController extends Controller
{

    public function __construct()
    {
        // check on permissions
        $this->middleware('can:manage-setting');
    }

    public function index()
    {
        breadcrumb([
            [
                'name' => __('view.dashboard'),
            ],
            [
                'name' => __('view.general_settings'),
            ],
        ]);


        $adminTheme = env('ADMIN_THEME', 'adminLte');
        return view($adminTheme . '.pages.settings', ['fields' => GeneralSettings::fields(), 'type' => GeneralSettings::group()]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function update(GeneralSettings $settings, GeneralRequest $request)
    {
        // dd($request);

        foreach (GeneralSettings::fields() as $field_key => $field) {
            if ($field['type'] == 'bool') {
                $settings->$field_key   =   isset($request->fields[$field_key]) ? true : false;
            } else if ($field['type'] == 'image') {
                if (isset($request->fields[$field_key])) {
                    $settingsModel = Settings::where('group', 'general')->where('name', $field_key)->first();
                    $settingsModel->syncFromMediaLibraryRequest($request->fields[$field_key])->toMediaCollection($field_key);
                } else {
                    $settingsModel = Settings::where('group', 'general')->where('name', $field_key)->first();
                    $settingsModel->clearMediaCollection($field_key);
                }
            } else {
                $settings->$field_key   =   ($field['translatable'] == true) ? json_encode($request->fields[$field_key]) : $request->fields[$field_key];
            }
        }
        $settings->save();

        return redirect()->back();
    }
}