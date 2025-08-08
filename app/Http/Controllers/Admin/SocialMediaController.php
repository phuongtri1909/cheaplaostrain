<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SocialMediaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $socials = SocialMedia::orderBy('order', 'asc')->paginate(10);
        return view('admin.pages.socials.index', compact('socials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.socials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'platform' => 'required|max:255',
            'icon' => 'required|max:255',
            'url' => 'required|url|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean'
        ], [
            'platform.required' => __('form.validation.required', ['attribute' => __('social.fields.name')]),
            'platform.max' => __('form.validation.max.string', ['attribute' => __('social.fields.name'), 'max' => 255]),
            'icon.required' => __('form.validation.required', ['attribute' => __('social.fields.icon')]),
            'icon.max' => __('form.validation.max.string', ['attribute' => __('social.fields.icon'), 'max' => 255]),
            'url.required' => __('form.validation.required', ['attribute' => __('social.fields.url')]),
            'url.url' => __('form.validation.url', ['attribute' => __('social.fields.url')]),
            'url.max' => __('form.validation.max.string', ['attribute' => __('social.fields.url'), 'max' => 255]),
            'order.integer' => __('form.validation.integer', ['attribute' => __('social.fields.order')]),
            'order.min' => __('form.validation.min.numeric', ['attribute' => __('social.fields.order'), 'min' => 0]),
            'status.boolean' => __('form.validation.boolean', ['attribute' => __('social.fields.status')])
        ]);

        SocialMedia::create($validated);

        return redirect()->route('admin.socials.index')
            ->with('success', __('messages.success.create', ['item' => __('social.item_name')]));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SocialMedia $social)
    {
        return view('admin.pages.socials.edit', compact('social'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SocialMedia $social)
    {
        $validated = $request->validate([
            'platform' => 'required|max:255',
            'icon' => 'required|max:255',
            'url' => 'required|url|max:255',
            'order' => 'nullable|integer|min:0',
            'status' => 'boolean'
        ], [
            'platform.required' => __('form.validation.required', ['attribute' => __('social.fields.name')]),
            'platform.max' => __('form.validation.max.string', ['attribute' => __('social.fields.name'), 'max' => 255]),
            'icon.required' => __('form.validation.required', ['attribute' => __('social.fields.icon')]),
            'icon.max' => __('form.validation.max.string', ['attribute' => __('social.fields.icon'), 'max' => 255]),
            'url.required' => __('form.validation.required', ['attribute' => __('social.fields.url')]),
            'url.url' => __('form.validation.url', ['attribute' => __('social.fields.url')]),
            'url.max' => __('form.validation.max.string', ['attribute' => __('social.fields.url'), 'max' => 255]),
            'order.integer' => __('form.validation.integer', ['attribute' => __('social.fields.order')]),
            'order.min' => __('form.validation.min.numeric', ['attribute' => __('social.fields.order'), 'min' => 0]),
            'status.boolean' => __('form.validation.boolean', ['attribute' => __('social.fields.status')])
        ]);

        $social->update($validated);

        return redirect()->route('admin.socials.index')
            ->with('success', __('messages.success.update', ['item' => __('social.item_name')]));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SocialMedia $social)
    {
        $social->delete();

        return redirect()->route('admin.socials.index')
            ->with('success', __('messages.success.delete', ['item' => __('social.item_name')]));
    }
}
