<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function addCategory(Request $request){
        $cate_request= $request->all();
        $category= Category::create($cate_request);
        return response()->json([
            "code"=>"successfully",
            "data"=>$category
        ]);
    }

    public function addPost(Request $request){
        // Lấy dữ liệu từ request
        $data = $request->only(['title', 'description', 'category_id']);
        $category=Category::where('id',$data['category_id'])->first();
        $user=auth()->user();
        if(!$category){
            return response()->json([
                "code"=>"failed",
                "data"=>"can not file category! "
            ]);
        }
        $post= new Post();
        $post->title=$request->title;
        $post->description=$request->description;
        $post->user_id=$user->id;
        $post->state = false;

        $category->post()->save($post);
        return response()->json([
            "code"=>"successfully",
            "data"=>$post
        ]);
    }
    public function getAllPost(){
        return response()->json([
            "code"=>"successfully",
            "data"=>Post::all()
        ]);
    }
    /*
     * update information of post
     */
    public function updatePost(Request $request, $post_id){
        $category=Category::where('id',$request->catgory_id)->first();
        if(!$category){
            return response()->json([
                "code"=>"failed",
                "data"=>"can not find category! "
            ],404);
        }

        $post= Post::where('id',$post_id)->first();
        $post->title=$request->title;
        $post->description= $request->description;
        $post->state=$request->state;
        $post->category_id=$request->category_id;
        $post->update();
        return response()->json([
            "code"=>"successfully",
            "data"=>$post
        ],200);
    }
    public function deletePost($post_id){
        $post= Post::where('id',$post_id)->first();
        if(!$post){
            return response()->json([
                "code"=>"failed",
                "message"=>"can not find post! "
            ],404);
        }

        $post->delete();
        return response()->json([
            "code"=>"successfully",
            "message"=>"delete post success"
        ],200);
    }
}
