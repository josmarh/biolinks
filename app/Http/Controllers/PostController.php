<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;

class PostController extends Controller
{
    public function index(Request $request, $projectId)
    {
        $title = $request->query('title');

        if(isset($productTitle)) {
            $posts = Post::where('project_id', $projectId)
                ->where('title', 'like', '%'.$productTitle.'%')
                ->orderBy('id', 'desc')
                ->paginate(15);
        }else {
            $posts = Post::where('project_id', $projectId)
                ->orderBy('id', 'desc')
                ->paginate(15);
        }

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $post = Post::create([
            'project_id' => $request->projectId,
            'slug' => $request->slug,
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'post' => $request->post,
            'images' => $request->images,
            'featured_image_style' => $request->featuredImageStyle,
            'media' => $request->media,
            'products' => $request->products,
            'courses' => $request->courses,
            'published_date' => $request->publishedDate,
            'author' => $request->author,
            'categories' => $request->categories,
            'payment_setting' => $request->postPaymentSettings,
            'published_status' => $request->publishedStatus
        ]);

        return response([
            'message' => 'Post created.',
            'postId' => $post->id,
            'status_code' => 201
        ], 201);
    }

    public function duplicate($id)
    {
        $post = Post::findOrFail($id);

        $newPost = Post::create([
            'project_id' => $post->project_id,
            'slug' => $post->slug,
            'title' => $post->title. '- copy',
            'excerpt' => $post->excerpt,
            'post' => $post->post,
            'images' => $post->images,
            'featured_image_style' => $post->featured_image_style,
            'media' => $post->media,
            'products' => $post->products,
            'courses' => $post->courses,
            'published_date' => $post->published_date,
            'author' => $post->author,
            'categories' => $post->categories,
            'payment_setting' => $post->payment_setting,
            'published_status' => $post->published_status
        ]);

        return response([
            'message' => 'Post duplicated.',
            'postId' => $newPost->id,
            'status_code' => 201
        ], 201);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);

        return new PostResource($post);
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string'
        ]);

        // Check for images and files

        $post->update([
            'project_id' => $request->projectId,
            'slug' => $request->slug,
            'title' => $data['title'],
            'excerpt' => $request->excerpt,
            'post' => $request->post,
            'images' => $request->images,
            'featured_image_style' => $request->featuredImageStyle,
            'media' => $request->media,
            'products' => $request->products,
            'courses' => $request->courses,
            'published_date' => $request->publishedDate,
            'author' => $request->author,
            'categories' => $request->categories,
            'payment_setting' => $request->postPaymentSettings,
        ]);

        return response([
            'message' => 'Post Updated.',
            'data' => new PostResource($post)
        ]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        // delete post id from category post


        $post->delete();

        return response([
            'message' => 'Post deleted.',
            'status_code' => 204
        ]);
    }
}
