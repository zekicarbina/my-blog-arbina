<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function welcome(){
        $posts = Post::all();

        // Uzmi Author username za svaki post
        foreach($posts as $post){
            $userName = User::where('id', $post->user_id)->get('name');
            $post['authorUsername'] = $userName[0]['name'];
        }

        return view('welcome', [
            'posts' => $posts
        ]);
    }
}
