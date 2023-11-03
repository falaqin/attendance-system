<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $setting = Setting::all();

        return response()->json([
            'settings' => $setting
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function store(Request $request)
    {
        foreach($request->all() as $key => $value) {
            Setting::find($value['id'])->update([
                'value' => $value['value']
            ]);
        }

        return response()->json(['message' => 'success', 'settings' => Setting::all()]);
    }
}
