<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::firstOrCreate(
            ['id' => 1],
            [
                'title' => 'About Us',
                'content' => 'Default content...',
                'is_active' => true
            ]
        );
        
        return view('admin.pages.about-us.edit', compact('aboutUs'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string',
            'content' => 'required|string',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'mission_title' => 'nullable|string|max:255',
            'mission_content' => 'nullable|string',
            'vision_title' => 'nullable|string|max:255',
            'vision_content' => 'nullable|string',
            'values_title' => 'nullable|string|max:255',
            'values_content' => 'nullable|string',
        ]);

        $aboutUs = AboutUs::firstOrCreate(['id' => 1]);
        $data = $request->all();

        // Handle image upload
        if ($request->hasFile('hero_image')) {
            if ($aboutUs->hero_image) {
                Storage::disk('public')->delete($aboutUs->hero_image);
            }
            $data['hero_image'] = $request->file('hero_image')->store('about-us', 'public');
        }

        // Process features
        if ($request->has('features')) {
            $features = [];
            foreach ($request->features as $feature) {
                if (!empty($feature['title']) && !empty($feature['description'])) {
                    $features[] = [
                        'title' => $feature['title'],
                        'description' => $feature['description'],
                        'icon' => $feature['icon'] ?? 'fas fa-check'
                    ];
                }
            }
            $data['features'] = $features;
        }

        // Process stats
        if ($request->has('stats')) {
            $stats = [];
            foreach ($request->stats as $stat) {
                if (!empty($stat['number']) && !empty($stat['label'])) {
                    $stats[] = [
                        'number' => $stat['number'],
                        'label' => $stat['label'],
                        'icon' => $stat['icon'] ?? 'fas fa-chart-line'
                    ];
                }
            }
            $data['stats'] = $stats;
        }

        $aboutUs->update($data);

        return back()->with('success', 'Nội dung About Us đã được cập nhật thành công!');
    }
}