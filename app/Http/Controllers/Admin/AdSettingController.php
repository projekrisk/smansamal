<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdSettingController extends Controller
{
    public function index()
    {
        $settings = [
            'adsense_header_enabled' => Setting::getBool('adsense_header_enabled', false),
            'adsense_header_code' => Setting::get('adsense_header_code', ''),
            'ad_in_article_enabled' => Setting::getBool('ad_in_article_enabled', false),
            'ad_in_article_code' => Setting::get('ad_in_article_code', ''),
            'ad_in_article_paragraph' => (int) Setting::get('ad_in_article_paragraph', 2),
            'ad_bottom_article_enabled' => Setting::getBool('ad_bottom_article_enabled', false),
            'ad_bottom_article_code' => Setting::get('ad_bottom_article_code', ''),
        ];

        return view('admin.ads.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'adsense_header_code' => 'nullable|string',
            'ad_in_article_code' => 'nullable|string',
            'ad_in_article_paragraph' => 'nullable|integer|min:1|max:20',
            'ad_bottom_article_code' => 'nullable|string',
        ]);

        Setting::set('adsense_header_enabled', $request->has('adsense_header_enabled') ? '1' : '0');
        Setting::set('adsense_header_code', $request->input('adsense_header_code'));

        Setting::set('ad_in_article_enabled', $request->has('ad_in_article_enabled') ? '1' : '0');
        Setting::set('ad_in_article_code', $request->input('ad_in_article_code'));
        Setting::set('ad_in_article_paragraph', (string) ($request->input('ad_in_article_paragraph') ?: 2));

        Setting::set('ad_bottom_article_enabled', $request->has('ad_bottom_article_enabled') ? '1' : '0');
        Setting::set('ad_bottom_article_code', $request->input('ad_bottom_article_code'));

        return redirect()->route('admin.ads.index')->with('success', 'Pengaturan iklan berhasil diperbarui.');
    }
}
