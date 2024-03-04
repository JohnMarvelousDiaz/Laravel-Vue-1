<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use App\Models\Like;
use App\Models\Comment;
class PostController extends Controller
{
    public function store(Request $req)
    {
        $validate = Validator::make($req->all(),[
            'content'=>'required|string'
        ]);

        if($validate->fails())
        {
            return response()->json([
                'errors'=>$validate->messages()
            ],422);
        }

        $user = $req->user();

        $post = new Post(['content' => $validate->getData()['content']]);
        $user->posts()->save($post);

        return response()->json([
            'message'=>'post has been saved'
        ],200);


    }


    public function general($page,Request $req)
    {


        $posts = Post::paginate(10, ['*'], 'page', $page);

        $postsArr = [];

        foreach ($posts as $post) {
            $postArr = [
                'post'=>$post,
                'user'=>User::find($post->user)->first(),
                'likes'=>Like::where('post_id',$post)->count(),
                'comments'=>Comment::where('post_id',$post)->count()
            ];

            array_push($postsArr,$postArr);
        }

        return response()->json([
            'posts'=>[$postsArr]
        ],200);

    }
}
