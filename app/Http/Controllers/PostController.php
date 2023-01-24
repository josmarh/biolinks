<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Resources\PostResource;
use App\Services\FileHandler;

class PostController extends Controller
{
    use FileHandler;

    public function index(Request $request, $projectId)
    {
        $title = $request->query('title');

        if(isset($title)) {
            $posts = Post::where('project_id', $projectId)
                ->where('title', 'like', '%'.$title.'%')
                ->orderBy('id', 'desc')
                ->with('user')
                ->paginate(15);
        }else {
            $posts = Post::where('project_id', $projectId)
                ->orderBy('id', 'desc')
                ->with('user')
                ->paginate(15);
        }

        return PostResource::collection($posts);
    }

    public function store(Request $request)
    {
        $user = $request->user();

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
            'author' => $user->id,
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

    public function duplicate(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = $request->user();

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
            'author' => $user->id,
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
        $post = Post::where('id', $id)->with('user')->first();
        
        if($post) {
            return new PostResource($post);
        }        
    }

    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $data = $request->validate([
            'title' => 'required|string'
        ]);

        // Check for images and media
        $images = json_decode($request->images);
        $files = json_decode($request->media);
        $newImgList = [];
        $newMediaList = [];

        foreach($images as $img) {
            if(str_contains($img, 'base64')) {
                $relativePath = $this->saveFile('post-images', $img);
                array_push($newImgList, $img);
            }else {
                array_push($newImgList, $img);
            }
        }

        foreach($files as $file) {
            if(str_contains($file->file, 'base64')) {
                $relativePath = $this->saveFile('post-media', $file->file);
                array_push($newMediaList, (object)[
                    'name' => $file->name, 
                    'file' => $relativePath,
                    'type' => $file->type,
                ]);
            }else {
                array_push($newMediaList, $file);
            }
        }

        // delete images and files from dir not needed


        $post->update([
            'slug' => $request->slug ? $request->slug : 'post-'.rand(111111, 999999),
            'title' => $data['title'],
            'excerpt' => $request->excerpt,
            'post' => $request->post,
            'images' => json_encode($newImgList),
            'featured_image_style' => $request->featuredImageStyle,
            'media' => json_encode($newMediaList),
            'products' => $request->products,
            'courses' => $request->courses,
            'published_date' => $request->publishedDate,
            'author' => $request->author,
            'categories' => $request->categories,
            'payment_setting' => $request->postPaymentSettings,
            'otp' => $request->otp,
            'content_preview' => $request->contentPreview,
            'plans' => $request->plans,
            'published_status' => $request->publishedStatus
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
