<?php

namespace App\Http\Controllers;

use App\Ads;
use App\Category;
use App\Comment;
use App\Http\Requests\UserCommentRequest;
use App\Post;
use App\Slide;
use System\Auth\Auth;

class HomeController extends Controller {
    public function index() {
        $slides = Slide::all();
        $newestAds = Ads::orderBy('created_at', 'desc')->limit(0, 6)->get();
        $bestAds = Ads::orderBy('view', 'desc')->limit(0, 4)->get();
        $posts = Post::where('published_at', '<=', date('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->limit(0, 4)->get();
        return view('app.index', compact('slides', 'newestAds', 'bestAds', 'posts'));
    }

    public function about() {
        return view('app.about');
    }

    public function category($id) {
        $category = Category::find($id);
        $ads = $category->ads()->get();
        $posts = $category->posts()->get();
        return view('app.category', compact('category', 'posts', 'ads'));
    }

    public function allAds() {
        $ads = Ads::all();
        return view('app.all-ads', compact('ads'));
    }

    public function ads($id) {
        $advertise = Ads::find($id);
        $galleries = $advertise->galleries()->get();
        $posts = Post::where('published_at', '<=', date('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->limit(0, 4)->get();
        $relatedAds = Ads::where('cat_id', $advertise->cat_id)->where('id', '!=', $id)->orderBy('created_at', 'desc')->limit(0, 4)->get();
        $categories = Category::all();
        return view('app.ads', compact('advertise', 'posts', 'galleries', 'relatedAds', 'categories'));
    }

    public function allPosts() {
        $posts = Post::all();
        return view('app.all-posts', compact('posts'));
    }

    public function posts($id) {
        $post = Post::find($id);
        $posts = Post::where('published_at', '<=', date('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->limit(0, 4)->get();
        $categories = Category::all();
        $comments = Comment::where('approved', 1)->whereNull('parent_id')->where('post_id', $id)->get();
        return view('app.post', compact('post', 'posts', 'categories', 'comments'));
    }

    public function comment($post_id) {
        $request = new UserCommentRequest();
        $inputs = $request->all();
        $inputs['post_id'] = $post_id;
        $inputs['approved'] = 0;
        $inputs['status'] = 0;
        $inputs['user_id'] = Auth::user()->id;
        Comment::create($inputs);
        return back();
    }

    public function search() {
        if (isset($_GET['search'])) {
            $search = '%' . $_GET['search'] . '%';
            $ads = Ads::where('title', 'LIKE', $search)->whereOr('tag', 'LIKE', $search)->get();
            $posts = Post::where('title', 'LIKE', $search)->get();
            return view('app.search', compact('ads', 'posts'));
        } else {
            return back();
        }
    }

    public function ajaxLastPosts() {
        //get data
        $posts = Post::where('published_at', '<=', date('Y-m-d H:i:s'))->orderBy('created_at', 'desc')->limit(0, 4)->get();
        foreach ($posts as $post) {
            $post->user = $post->author();
            unset($post->user_id);
            $post->created_at = \Morilog\Jalali\Jalalian::forge($post->created_at)->format('%B %d، %Y');
            $post->url = route('home.posts', [$post->id]);
        }
        header('Content-type: application/json');
        $result = json_encode($posts, JSON_UNESCAPED_UNICODE);
        echo $result;
        exit;
    }
}