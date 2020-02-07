<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Feed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FeedApi extends Controller
{
    public function feed()
    {
        $feed = Feed::orderBy('id', 'DESC')->with('user')->paginate(10);
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $feed,
        ]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $v = Validator::make(request()->all(), [
            'description' => 'required|min:3',
            'image' => 'mimes:jpg,png,jpeg',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $v->errors(),
            ]);
        }
        $image = \request()->image;
        $name = uniqid() . $image->getClientOriginalName();
        $path = ('feed');
        $image->move($path, $name);
        //$des = "lorem tesitng";
        $feeds = Feed::create([
            'description' => \request()->description,
            'user_id' => Auth::id(),
            'image' => " $path /$name"
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Success',
            'data' => $feeds,

        ]);
    }

    public function delete()
    {
        dd('hello');
    }

    public function createComment()
    {
        $v = Validator::make(request()->all(), [
            "feed_id" => 'required',
            "comment" => 'required'
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $v->errors(),
            ]);
        }
        $user_id = Auth::id();
        $feed_id = \request()->feed_id;
        $comment = \request()->comment;
        $comment = Comment::create([
            'user_id' => $user_id,
            'feed_id' => $feed_id,
            'comment' => $comment
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => $comment
        ]);
    }

    public function getComment()
    {

        $v = Validator::make(request()->all(), [
            "feed_id" => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $v->errors(),
            ]);
        }

        $feed_id = \request()->feed_id;
        $comment = Comment::where('feed_id',$feed_id)->with('user')->paginate(10);
        return response()->json([
            'status' => 200,
            'message' => 'successfully',
            'data' => $comment
        ]);
    }

    public function deleteComment()
    {
        $v = Validator::make(request()->all(), [
            "comment_id" => 'required',
        ]);
        if ($v->fails()) {
            return response()->json([
                'status' => 500,
                'message' => 'fail',
                'data' => $v->errors(),
            ]);
        }

        $comment_id = \request()->comment_id;
        Comment::where('id', $comment_id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Successfully',
            'data' => null
        ]);

    }
}
