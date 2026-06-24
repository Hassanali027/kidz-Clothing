<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Blog;

class BlogController extends Controller
{
    /**
     * Show the Blog listing page.
     */
    public function index()
    {
        $blogs = Blog::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('blog-page', [
            'pageTitle'       => 'Blog | Kidz Wear',
            'metaDescription' => 'Read the latest tips, trends, and stories from Kidz Wear — your guide to kids fashion.',
            'blogs'           => $blogs
        ]);
    }

    /**
     * Show a single blog post.
     */
    public function show($slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedPosts = Blog::where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->take(3)
            ->get();

        return view('blog-post', [
            'blog' => $blog,
            'relatedPosts' => $relatedPosts,
            'pageTitle' => $blog->title . ' | Kidz Wear',
            'metaDescription' => Str::limit(strip_tags($blog->description), 160)
        ]);
    }
}
