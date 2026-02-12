<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * ADMIN: List all blogs (NO default status filter)
     */
    public function index(Request $request)
    {
        $query = Blog::with('category');

        // Optional status filter (admin controlled)
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Optional category filter
        if ($request->filled('categories')) {
            $cats = is_array($request->categories)
                ? $request->categories
                : explode(',', $request->categories);

            $query->whereIn('category_id', $cats);
        }

        // Optional search
        if ($request->filled('search')) {
            $keyword = trim($request->search);
            $query->where(function ($q) use ($keyword) {
                $q->where('blog_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('short_description', 'LIKE', "%{$keyword}%")
                    ->orWhere('blog_content', 'LIKE', "%{$keyword}%");
            });
        }

        // Order newest first
        $query->orderBy('updated_at', 'desc');

        return response()->json($query->get());
    }


    /**
     * PUBLIC: List only published blogs (website)
     */
    // public function publicIndex(Request $request)
    // {
    //     $query = Blog::with('category')
    //         ->whereRaw('LOWER(status) = ?', ['published']);

    //     if ($request->filled('categories')) {
    //         $cats = is_array($request->categories)
    //             ? $request->categories
    //             : explode(',', $request->categories);

    //         $query->whereIn('category_id', $cats);
    //     }

    //     if ($request->filled('search')) {
    //         $keyword = trim($request->search);
    //         $query->where(function ($q) use ($keyword) {
    //             $q->where('blog_name', 'LIKE', "%{$keyword}%")
    //                 ->orWhere('short_description', 'LIKE', "%{$keyword}%")
    //                 ->orWhere('blog_content', 'LIKE', "%{$keyword}%");
    //         });
    //     }

    //     $query->orderBy('published_at', 'desc');

    //     return response()->json($query->get());
    // }
    /**
 * PUBLIC: List only published blogs (website)
 *
 * Supports:
 * - category filtering
 * - text search
 * - related blogs (slug-based, OPTIONAL)
 */



/**
 * PUBLIC: List only published blogs (website)
 *
 * Supports:
 * - category filter
 * - search
 * - related blogs (tag based, optional)
 */
public function publicIndex(Request $request)
{
    $query = Blog::with('category')
        ->whereRaw('LOWER(status) = ?', ['published']);

    /* -------------------------------------------------
       CATEGORY FILTER (optional)
    ------------------------------------------------- */
    if ($request->filled('categories')) {
        $cats = is_array($request->categories)
            ? $request->categories
            : explode(',', $request->categories);

        $query->whereIn('category_id', $cats);
    }

    /* -------------------------------------------------
       SEARCH FILTER (optional)
    ------------------------------------------------- */
    if ($request->filled('search')) {
        $keyword = trim($request->search);

        $query->where(function ($q) use ($keyword) {
            $q->where('blog_name', 'LIKE', "%{$keyword}%")
              ->orWhere('short_description', 'LIKE', "%{$keyword}%")
              ->orWhere('blog_content', 'LIKE', "%{$keyword}%");
        });
    }

    /* -------------------------------------------------
       RELATED BLOGS (OPTIONAL – TAG BASED)
       Triggered only when `related_to` (slug) is present
    ------------------------------------------------- */
    /* -------------------------------------------------
   RELATED BLOGS (OPTIONAL – CATEGORY BASED)
   Triggered only when `related_to` (slug) is present
------------------------------------------------- */
if ($request->filled('related_to')) {

    // Find the current published blog by slug
    $currentBlog = Blog::where('url_friendly_title', $request->related_to)
        ->whereRaw('LOWER(status) = ?', ['published'])
        ->first();

    // If blog not found → return empty response safely
    if (!$currentBlog) {
        return response()->json([]);
    }

    // Fetch related blogs from SAME CATEGORY
    $relatedBlogs = Blog::with('category')
        ->whereRaw('LOWER(status) = ?', ['published'])
        ->where('blog_id', '!=', $currentBlog->blog_id) // exclude current blog
        ->where('category_id', $currentBlog->category_id)
        ->orderBy('published_at', 'desc')
        // ->limit(4)
        ->get();

    return response()->json($relatedBlogs);
}


    /* -------------------------------------------------
       DEFAULT ORDER (newest first)
    ------------------------------------------------- */
    $query->orderBy('published_at', 'desc');

    return response()->json($query->get());
}


    /**
     * CREATE blog
     */
    public function store(Request $request)
    {
        $request->validate([
            'blog_name'    => 'required|string|max:255',
            'category_id'  => 'nullable|exists:categories,id',
            'status'       => 'required|in:draft,published,archived',
            'recent_blog'  => 'required|in:YES,NO',
            'is_trending'     => 'required|in:yes,no',  //newly added
            'published_at' => 'nullable|date',
        ]);

        // Generate unique slug
        $baseSlug = Str::slug($request->blog_name);
        $slug = $baseSlug;
        $counter = 1;

        while (Blog::where('url_friendly_title', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $blog = Blog::create([
            'blog_name'          => $request->blog_name,
            'url_friendly_title' => $slug,
            'category_id'        => $request->category_id,
            'banner_image'       => $request->banner_image,
            'thumbnail_image'    => $request->thumbnail_image,
            'short_description'  => $request->short_description,
            'blog_content'       => $request->blog_content,
            'published_by'       => $request->published_by,
            'published_at'       => $request->published_at,
            'status'             => $request->status,
            'recent_blog'        => $request->recent_blog,
            'is_trending'           => $request->is_trending,  //newly added
            'meta_title'         => $request->meta_title,
            'meta_description'   => $request->meta_description,
            'meta_keywords'      => $request->meta_keywords,
        ]);

        return response()->json([
            'message' => 'Blog created successfully',
            'blog'    => $blog->load('category'),
        ], 201);
    }

    /**
     * SHOW blog (by ID or slug)
     */
    public function show($id)
    {
        if (is_numeric($id)) {
            return Blog::with('category')->findOrFail($id);
        }

        return Blog::with('category')
            ->where('url_friendly_title', $id)
            ->firstOrFail();
    }

    /**
     * UPDATE blog (SAFE — ID NEVER CHANGES)
     */

    public function update(Request $request, $id)
    {
        $blog = Blog::findOrFail($id);

        $request->validate([
            'blog_name'    => 'sometimes|required|string|max:255',
            'status'       => 'in:draft,published,archived',
            'recent_blog'  => 'in:YES,NO',
            'url_friendly_title' => 'string|max:100',//newly added
            'is_trending'  => 'in:yes,no',  //newly added
            'published_at' => 'nullable|date',
        ]);

        $data = $request->only([
            'blog_name',
            'short_description',
            'blog_content',
            'published_by',
            'published_at',
            'status',
            'recent_blog',
            'is_trending',  //newly added
            'url_friendly_title',//newly added
            'meta_title',
            'meta_description',
            'meta_keywords',
            'banner_image',
            'thumbnail_image',
            'extra',
        ]);

        // 🔥 CRITICAL FIX
        if ($request->has('category_id')) {
            $categoryId = $request->category_id;

            // normalize bad frontend values
            if ($categoryId === '' || $categoryId === 'null') {
                $data['category_id'] = null;
            } else {
                $exists = DB::table('blog_categories')
                    ->where('category_id', $categoryId)
                    ->exists();

                $data['category_id'] = $exists ? $categoryId : null;
            }
        }

        $blog->update($data);

        return response()->json([
            'message' => 'Blog updated successfully',
            'blog' => $blog->load('category'),
        ]);
    }

    /**
     * DELETE blog
     */
    public function destroy($id)
    {
        Blog::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Blog deleted successfully',
        ]);
    }
}
