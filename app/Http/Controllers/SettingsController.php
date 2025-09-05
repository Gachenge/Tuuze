<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $businessId = auth()->user()->business_id;
        $settings = Setting::with('business')->where('business_id', $businessId)->first();
        if (!$settings)
            return redirect('/settings/create');
        return redirect()->route('settings.edit', ['id' => $settings->id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $businessId = auth()->user()->business_id;
        $business = Business::findOrFail($businessId);
        return view('Settings.create', compact('business'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
            'business_id' => 'required|exists:businesses,id'
        ]);

        $settings = Setting::create([
            'primary_color' => $request->primary_color,
            'secondary_color' => $request->secondary_color,
            'business_id' => $request->business_id
        ]);
        return redirect()->route('settings.edit', ['id' => $settings->id])->with('status', 'Settings saved');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $settings = Setting::with('business')->find($id);
        return view('settings.edit', compact('settings'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $settings = Setting::findOrFail($id);
        $request->validate([
            'primary_color' => 'nullable|string',
            'secondary_color' => 'nullable|string',
        ]);
        $settings->primary_color = $request->primary_color;
        $settings->secondary_color = $request->secondary_color;
        $settings->save();
        return back()->with('status', 'Settings updates successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
