<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }


    public function welcome(){
        $posts = Post::all();

        foreach($posts as $post){
            $userName = User::where('id', $post->user_id)->get('name');
            $post['authorUsername'] = $userName[0]['name'];
        }

        return view('welcome', [
            'posts' => $posts
        ]);
    }

    public function post($slug, $id){
        // Uzmi Informacije o Post-u
        $postData = Post::where('id', $id)->firstOrFail();

        // Uzmi 'name' iz tabele User od autora, potraga za autorom ide preko ID'a u user tabeli.
        $userName = User::where('id', $postData->user_id)->get('name');

        // Dodaj 'authorUsername' u array sa informacijama post-a.
        $postData['authorUsername'] = $userName[0]['name'];

        return view('postView', [
            'postData' => $postData
        ]);
    }
}
