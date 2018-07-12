<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Controllers\Admin\TagsController;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::paginate(6);

        return view('pages.index', compact(
            'posts'
            ));
    }

    public function show($slug){
        $post = Post::where('slug', $slug)->firstOrFail();
        return view('pages.show', compact('post'));
    }

    public function tag($slug)
    {
        $tags = Tag::where('slug', $slug)->firstOrFail();
        $posts = $tags->posts()->paginate(6);
        return view('pages.list', compact('posts') );
    }

    public function category($slug)
    {
        $categories = Category::where('slug', $slug)->firstOrFail();
        $posts = $categories->posts()->paginate(6);
        return view('pages.list', compact('posts'));
    }
}
