<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class DashController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        return view('dashboard');
    }

    public function myPosts()
    {
        // Provjeri jel Admin
        $admin = User::where('id', Auth::user()->id)->firstOrFail(['admin', 'id']);

        if ($admin->admin == 1) {
            // Uzmi sve Postove
            $posts = Post::all();

            // Uzmi informacije o korisniku iz svakog post-a
            foreach ($posts as $post) {
                $userName = User::where('id', $post->user_id)->get('name');
                $post['authorUsername'] = $userName[0]['name'];
            }
        } else {
            // Ako nije admin, uzmi samo postove od ulogovanog korisnika
            $posts = Post::where('user_id', Auth::user()->id)->get();
        }
        return view('myPosts', [
            // Return se radi u formatu, "Kako ga View Vidi" => "Vrijednost Koja se salje".
            'posts' => $posts,
            'admin' => $admin->admin,
            'currentUserId' => $admin->id
        ]);
    }

    public function deletePost($postId)
    {
        Post::where('id', $postId)->delete();
        return $this->myPosts();
    }

    public function editPost(Request $request)
    {
        $data = Post::where('id', $request->postId)->firstOrFail();
        $data->content = request('content');
        $data->save();
        return True;
    }

    public function deleteUser($userId)
    {
        // Provjeri da li zahtev dolazi od administratora
        if (Auth::user()->admin) {
            // Obrisi Korisnika
            User::where('id', $userId)->delete();

            // Obrisi Postove
            Post::where('user_id', $userId)->delete();
        }
        return $this->myPosts();
    }

    public function myProfile(){
        return view('myProfile', [
            'profileData' => Auth::user(),
        ]);
    }

    public function editUser(Request $request)
    {
        $data = User::where('id', Auth::user()->id)->firstOrFail();
        $data->email = request('inputEmail');
        $data->name = request('inputName');
        $data->save();
        return True;
    }

    public function createPost(){
        return view('createPost');
    }

    public function createPostSubmit(Request $request){
        $object = new Post;
        $object->title = request('title');
        $object->content = request('content');
        $object->short_description = request('short');
        $object->slug = request('slug');
        $object->picture = request('picture');
        $object->user_id = Auth::user()->id;

        $object->save();

        // Send back to Posts List
        return True;
    }
}
