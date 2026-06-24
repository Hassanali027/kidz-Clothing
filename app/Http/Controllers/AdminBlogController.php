<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('created_at', 'desc')->get();
        return view('admin.blogs', compact('blogs'));
    }

    public function create()
    {
        return view('admin.add-blog');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $slug = $request->slug ?: Str::slug($request->title);
        
        // Ensure slug is unique
        $originalSlug = $slug;
        $count = 1;
        while (Blog::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $thumbnail = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('blogs', 'public');
        }

        Blog::create([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'status' => $request->status ?? 'published',
            'show_on_home' => $request->has('show_on_home'),
        ]);

        return redirect()->route('admin.blogs')->with('success', 'Blog created successfully');
    }

    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admin.edit-blog', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $slug = $request->slug ?: Str::slug($request->title);
        
        // Ensure slug is unique if changed
        if ($slug !== $blog->slug) {
            $originalSlug = $slug;
            $count = 1;
            while (Blog::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
        }

        $thumbnail = $blog->thumbnail;
        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->store('blogs', 'public');
        }

        $blog->update([
            'title' => $request->title,
            'slug' => $slug,
            'description' => $request->description,
            'thumbnail' => $thumbnail,
            'status' => $request->status ?? 'published',
            'show_on_home' => $request->has('show_on_home'),
        ]);

        return redirect()->route('admin.blogs')->with('success', 'Blog updated successfully');
    }

    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();
        return redirect()->route('admin.blogs')->with('success', 'Blog deleted successfully');
    }
}
