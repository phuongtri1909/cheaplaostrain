<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Blog;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    /**
     * Display a listing of the blogs.
     */
    public function index(Request $request)
    {
        $query = Blog::query();

        // Filter by title if provided
        if ($request->filled('title')) {
            $searchTerm = $request->title;
            $query->where('title', 'LIKE', '%' . $searchTerm . '%');
        }

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('is_published', $request->status === 'published');
        }

        // Filter by featured if provided
        if ($request->filled('featured')) {
            $query->where('is_featured', $request->featured === 'featured');
        }

        // Order by creation date
        $blogs = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new blog.
     */
    public function create()
    {
        return view('admin.pages.blogs.create');
    }

    /**
     * Store a newly created blog in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'slug' => 'nullable|string|unique:blogs,slug',
            'featured_image' => 'required|image|mimes:jpeg,png,jpg',
            'author_name' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'subtitle.max' => 'Phụ đề không được vượt quá 255 ký tự',
            'content.required' => 'Nội dung là bắt buộc',
            'featured_image.required' => 'Ảnh đại diện là bắt buộc',
            'featured_image.image' => 'File phải là hình ảnh',
            'featured_image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp',
            'featured_image.max' => 'Ảnh không được vượt quá 2MB',
            'slug.unique' => 'Slug đã tồn tại',
            'author_name.max' => 'Tên tác giả không được vượt quá 255 ký tự',
        ]);

        try {
            // Prepare data
            $blogData = [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'content' => $request->content,
                'slug' => $request->slug ? Str::slug($request->slug) : null,
                'author_name' => $request->author_name,
                'is_published' => $request->has('is_published'),
                'is_featured' => $request->has('is_featured'),
                'published_at' => $request->has('is_published') ? now() : null,
            ];

            // Handle featured image upload with WebP conversion
            if ($request->hasFile('featured_image')) {
                // Create directory if it doesn't exist
                $directory = 'blogs/featured';
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }

                $image = $request->file('featured_image');
                $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';

                // Process and optimize the image
                $img = Image::make($image);

                // Resize if larger than 1200px width while keeping aspect ratio
                if ($img->width() > 1200) {
                    $img->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Convert to WebP with 85% quality
                $img->encode('webp', 85);

                // Save to storage
                $path = $directory . '/' . $filename;
                Storage::disk('public')->put($path, $img->stream());
                $blogData['featured_image'] = $path;
            }

            Blog::create($blogData);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog đã được tạo thành công!');
        } catch (\Exception $e) {
            // Clean up if any errors
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi tạo blog.');
        }
    }

    /**
     * Show the form for editing the specified blog.
     */
    public function edit(Blog $blog)
    {
        return view('admin.pages.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified blog in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'content' => 'required|string',
            'slug' => 'required|string|unique:blogs,slug,' . $blog->id,
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg',
            'author_name' => 'nullable|string|max:255',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự',
            'subtitle.max' => 'Phụ đề không được vượt quá 255 ký tự',
            'content.required' => 'Nội dung là bắt buộc',
            'slug.required' => 'Slug là bắt buộc',
            'slug.unique' => 'Slug đã tồn tại',
            'featured_image.image' => 'File phải là hình ảnh',
            'featured_image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, webp',
            'featured_image.max' => 'Ảnh không được vượt quá 2MB',
            'author_name.max' => 'Tên tác giả không được vượt quá 255 ký tự',
        ]);

        try {
            // Prepare data
            $blogData = [
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'content' => $request->content,
                'slug' => $request->slug ? Str::slug($request->slug) : $blog->slug,
                'author_name' => $request->author_name,
                'is_published' => $request->has('is_published'),
                'is_featured' => $request->has('is_featured'),
            ];

            // Update published_at if status changed
            if ($request->has('is_published') && !$blog->is_published) {
                $blogData['published_at'] = now();
            } elseif (!$request->has('is_published')) {
                $blogData['published_at'] = null;
            }

            // Handle featured image upload with WebP conversion
            if ($request->hasFile('featured_image')) {
                // Delete old image if it exists
                if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                    Storage::disk('public')->delete($blog->featured_image);
                }

                // Create directory if it doesn't exist
                $directory = 'blogs/featured';
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }

                $image = $request->file('featured_image');
                $filename = time() . '_' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';

                // Process and optimize the image
                $img = Image::make($image);

                // Resize if larger than 1200px width while keeping aspect ratio
                if ($img->width() > 1200) {
                    $img->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Convert to WebP with 85% quality
                $img->encode('webp', 85);

                // Save to storage
                $path = $directory . '/' . $filename;
                Storage::disk('public')->put($path, $img->stream());
                $blogData['featured_image'] = $path;
            }

            $blog->update($blogData);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog đã được cập nhật thành công!');
        } catch (\Exception $e) {
            // Clean up if any errors
            if (isset($path) && Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()->withInput()
                ->with('error', 'Có lỗi xảy ra khi cập nhật blog.');
        }
    }

    /**
     * Remove the specified blog from storage.
     */
    public function destroy(Blog $blog)
    {
        try {
            // Delete featured image if exists
            if ($blog->featured_image && Storage::disk('public')->exists($blog->featured_image)) {
                Storage::disk('public')->delete($blog->featured_image);
            }

            $blog->delete();

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Có lỗi xảy ra khi xóa blog.');
        }
    }

    /**
     * Upload image for CKEditor
     */
    public function uploadImage(Request $request)
    {
        try {
            $request->validate([
                'upload' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            ]);

            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                
                // Create directory if it doesn't exist
                $directory = 'blogs/content';
                if (!Storage::disk('public')->exists($directory)) {
                    Storage::disk('public')->makeDirectory($directory);
                }

                // Generate unique filename
                $filename = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.webp';
                
                // Process and optimize the image
                $img = Image::make($file);

                // Resize if larger than 800px width while keeping aspect ratio
                if ($img->width() > 800) {
                    $img->resize(800, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }

                // Convert to WebP with 85% quality
                $img->encode('webp', 85);

                // Save to storage
                $path = $directory . '/' . $filename;
                Storage::disk('public')->put($path, $img->stream());

                $url = Storage::disk('public')->url($path);

                // Return CKEditor format response
                return response()->json([
                    'fileName' => $filename,
                    'uploaded' => 1,
                    'url' => $url
                ]);
            }

            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Không có file được tải lên.'
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => 0,
                'error' => [
                    'message' => 'Lỗi khi tải lên ảnh: ' . $e->getMessage()
                ]
            ]);
        }
    }
}
