<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\BannerHome;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class BannerHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = BannerHome::orderBy('order', 'asc')->paginate(10);
        return view('admin.pages.banner-home.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.banner-home.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg',
            'status' => 'required|boolean',
            'order' => 'nullable|integer|min:0'
        ],[
            'image.required' => __('form.validation.required', ['attribute' => __('banner.fields.image')]),
            'image.image' => __('form.validation.image', ['attribute' => __('banner.fields.image')]),
            'image.mimes' => __('form.validation.mimes', ['attribute' => __('banner.fields.image')]),
            'status.required' => __('form.validation.required', ['attribute' => __('banner.fields.status')]),
            'status.boolean' => __('form.validation.boolean', ['attribute' => __('banner.fields.status')]),
            'order.integer' => __('form.validation.integer', ['attribute' => __('banner.fields.order')]),
            'order.min' => __('form.validation.min.numeric', ['attribute' => __('banner.fields.order'), 'min' => 0])
        ]);

        // Handle file upload and conversion to WebP
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'banner-' . Str::random(10) . '.webp';

            // Create WebP image with reduced quality
            $img = Image::make($image);
            $img->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Convert to WebP and save
            $path = 'public/banners/' . $filename;
            Storage::put($path, $img->encode('webp', 80));

            $validated['image'] = 'banners/' . $filename;
        }

        BannerHome::create($validated);

        return redirect()->route('admin.banner-home.index')
            ->with('success', __('messages.success.create', ['item' => __('banner.item_name')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BannerHome $bannerHome)
    {
        return view('admin.pages.banner-home.edit', compact('bannerHome'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BannerHome $bannerHome)
    {
        $validated = $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg',
            'status' => 'required|boolean',
            'order' => 'nullable|integer|min:0'
        ],[
            'image.image' => __('form.validation.image', ['attribute' => __('banner.fields.image')]),
            'image.mimes' => __('form.validation.mimes', ['attribute' => __('banner.fields.image')]),
            'status.required' => __('form.validation.required', ['attribute' => __('banner.fields.status')]),
            'status.boolean' => __('form.validation.boolean', ['attribute' => __('banner.fields.status')]),
            'order.integer' => __('form.validation.integer', ['attribute' => __('banner.fields.order')]),
            'order.min' => __('form.validation.min.numeric', ['attribute' => __('banner.fields.order'), 'min' => 0])
        ]);

        // Handle file upload and conversion to WebP
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($bannerHome->image && Storage::exists('public/' . $bannerHome->image)) {
                Storage::delete('public/' . $bannerHome->image);
            }

            $image = $request->file('image');
            $filename = 'banner-' . Str::random(10) . '.webp';

            // Create WebP image with reduced quality
            $img = Image::make($image);
            $img->resize(1920, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

            // Convert to WebP and save
            $path = 'public/banners/' . $filename;
            Storage::put($path, $img->encode('webp', 80));

            $validated['image'] = 'banners/' . $filename;
        }

        $bannerHome->update($validated);

        return redirect()->route('admin.banner-home.index')
            ->with('success', __('messages.success.update', ['item' => __('banner.item_name')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BannerHome $bannerHome)
    {
        // Delete image file if exists
        if ($bannerHome->image && Storage::exists('public/' . $bannerHome->image)) {
            Storage::delete('public/' . $bannerHome->image);
        }

        $bannerHome->delete();

        return redirect()->route('admin.banner-home.index')
            ->with('success', __('messages.success.delete', ['item' => __('banner.item_name')]));
    }
}
