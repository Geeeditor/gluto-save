<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ActivateDashboard;
use Illuminate\Support\Facades\Storage;


class ConfigurationController extends Controller
{
    //
    public function redirectConfigLayout(){
        $appSettings = AppSetting::first();

        if($appSettings) {
            return redirect()->route('app.config');
        }

        return redirect()->route('platform.config.index');
    }

    public function index () {
        return view('config.setting' );
    }

    public function save(Request $request)
    {

        // dd($request->all());

        // dd($request->input('appSetting.app_social_links'));
        // Validate the incoming request
        $data = $request->validate([
            'appSetting.app_name' => 'required|string',
            'appSetting.app_description' => 'required|string',
            'appSetting.app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'appSetting.app_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=50,min_height=50,max_width=100,max_height=100',
            'appSetting.support_email' => 'nullable|email',
            'appSetting.app_email' => 'required|email|unique:app_settings,app_email,' . ($request->appSetting['id'] ?? 'NULL'), // Unique validation excluding current record
            'appSetting.app_phone' => 'nullable|string',
            'appSetting.app_address' => 'nullable|string',
            'appSetting.withdrawal_enabled' => 'boolean',
            'appSetting.contribution_enabled' => 'boolean',
            'appSetting.subscription_enabled' => 'boolean',
            'appSetting.app_social_links.whatsapp' => 'nullable|url',
        'appSetting.app_social_links.twitter' => 'nullable|url',
        'appSetting.app_social_links.instagram' => 'nullable|url',
        'appSetting.app_social_links.facebook' => 'nullable|url',
        ]);

        $appSettings = AppSetting::first();

        if ($appSettings) {
            return redirect()->route('platform.config.update', ['id' => $appSettings->id])
                ->with('info', 'You already have a configuration setup, here\'s your updateable configuration setup');
        }

        // Handle the favicon upload
        if ($request->hasFile('appSetting.app_favicon')) {
            $imageI = $request->file('appSetting.app_favicon');
            $fileName1 = 'favicon_' . Str::random(3) . '.' . $imageI->getClientOriginalExtension();
            $imagePath1 = $imageI->storeAs('config/', $fileName1, 'public');
            $data['appSetting']['app_favicon'] = $fileName1; // Store the path
        }

        // Handle the logo upload
        if ($request->hasFile('appSetting.app_logo')) {
            $imageII = $request->file('appSetting.app_logo');
            $fileName2 = 'logo_' . Str::random(3) . '.' . $imageII->getClientOriginalExtension();
            $imagePath2 = $imageII->storeAs('config/', $fileName2, 'public');
            $data['appSetting']['app_logo'] = $fileName2; // Store the path
        }

        // Prepare social links as a JSON string
        $data['appSetting']['app_social_links'] = json_encode([
            'whatsapp' => $request->input('appSetting.app_social_links.whatsapp'),
        'twitter' => $request->input('appSetting.app_social_links.twitter'),
        'instagram' => $request->input('appSetting.app_social_links.instagram'),
        'facebook' => $request->input('appSetting.app_social_links.facebook'),
        ]);



        // Create a new settings record if none exists
        AppSetting::create($data['appSetting']);

        // Toast::info('App settings updated successfully.');

        return redirect()->route('platform.settings'); // Adjust the route as necessary
    }

    public function update(){
        $appSettings = AppSetting::first();

        $socialLinks =  json_decode($appSettings->app_social_links, true);

        // dd($socialLinks);

        return view('config.update', ['appSettings' => $appSettings, 'socialLinks' => $socialLinks]);

    }

    public function updateConfig(Request $request, $id){
        // Validate the incoming request
        $data = $request->validate([
            'appSetting.app_name' => 'required|string',
            'appSetting.app_description' => 'required|string',
            'appSetting.app_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'appSetting.app_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|dimensions:min_width=50,min_height=50,max_width=100,max_height=100',
            'appSetting.support_email' => 'nullable|email',
            'appSetting.app_email' => 'required|email',
            'appSetting.app_phone' => 'nullable|string',
            'appSetting.app_address' => 'nullable|string',
            'appSetting.withdrawal_enabled' => 'boolean',
            'appSetting.contribution_enabled' => 'boolean',
            'appSetting.subscription_enabled' => 'boolean',
            'appSetting.app_social_links.whatsapp' => 'nullable|url',
            'appSetting.app_social_links.twitter' => 'nullable|url',
            'appSetting.app_social_links.instagram' => 'nullable|url',
            'appSetting.app_social_links.facebook' => 'nullable|url',
        ]);

        // Fetch the existing settings
        $appSetting = AppSetting::findOrFail($id);

        // Handle favicon upload
        if ($request->hasFile('appSetting.app_favicon')) {
            // Delete old favicon if exists
            if ($appSetting->app_favicon) {
                Storage::delete('public/' . $appSetting->app_favicon);
            }
            $imageI = $request->file('appSetting.app_favicon');
            $fileNameI = 'favicon_' . Str::random(3) . '.' . $imageI->getClientOriginalExtension();
            $imagePathI = $imageI->storeAs('config/', $fileNameI, 'public');
            $data['appSetting']['app_favicon'] = $fileNameI; // Store the path
        } else {
            $data['appSetting']['app_favicon'] = $appSetting->app_favicon; // Keep the old value
        }

        // Handle logo upload
        if ($request->hasFile('appSetting.app_logo')) {
            // Delete old logo if exists
            if ($appSetting->app_logo) {
                Storage::delete('public/' . $appSetting->app_logo);
            }
            $imageII = $request->file('appSetting.app_logo');
            $fileNameII = 'logo_' . Str::random(3) . '.' . $imageII->getClientOriginalExtension();
            $imagePathII = $imageII->storeAs('config/', $fileNameII, 'public');
            $data['appSetting']['app_logo'] = $fileNameII; // Store the path
        } else {
            $data['appSetting']['app_logo'] = $appSetting->app_logo; // Keep the old value
        }

        if($request->input('appSetting.app_social_links.whatsapp') || $request->input('appSetting.app_social_links.whatsapp') ||  $request->input('appSetting.app_social_links.instagram')  || $request->input('appSetting.app_social_links.facebook' )) {
        // Prepare social links as a JSON string
        $data['appSetting']['app_social_links'] = json_encode([
            'whatsapp' => $request->input('appSetting.app_social_links.whatsapp'),
            'twitter' => $request->input('appSetting.app_social_links.twitter'),
            'instagram' => $request->input('appSetting.app_social_links.instagram'),
            'facebook' => $request->input('appSetting.app_social_links.facebook'),
        ]);
        }
        // Update the AppSetting record
        $appSetting->update($data['appSetting']);

        // Toast::info('App settings updated successfully.');

        return redirect()->route('platform.settings'); // Adjust the route as necessary
    }

    public function updateWallet(Request $request, $id)
    {
        dd('hit');

        $data = $request->validate([
            'amount' => 'required|numeric|min:0',
            'action' => 'required|in:add,deduct',
        ]);

        $dashboard = ActivateDashboard::find($id);

        if ($dashboard) {
            // Update the wallet balance based on the action
            if ($data['action'] === 'add') {
                $dashboard->wallet_balance += $data['amount'];
            } elseif ($data['action'] === 'deduct') {
                $dashboard->wallet_balance -= $data['amount'];
            } else {
                return redirect()->back()->with('message', 'No wallet balance action selected');
            }

            $dashboard->save();
            return redirect()->back()->with('message', 'Wallet balance updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Dashboard not found.');
        }
    }
}
