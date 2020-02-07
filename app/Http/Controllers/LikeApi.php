<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeApi extends Controller
{
    public function like()
    {
        $user_id = Auth::id();
        $feed_id = \request()->feed_id;
        //return $this->isLike($user_id, $feed_id);
        if (!$this->isLike($user_id, $feed_id)) {
            $like = Like::create([
                'user_id' => $user_id,
                'feed_id' => $feed_id,
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'successfully',
                'data' => $like,
            ]);
        }
        return response()->json([
            'status' => 500,
            'message' => 'fail',
            'data' => 'already_like',
        ]);
    }

    public function isLike($user_id, $feed_id)
    {
        $islike = Like::where('user_id', $user_id)->where('feed_id', $feed_id)->count();
        return $islike;
        if ($islike) {
            return true;
        }
        return false;
    }

    public function disLike()
    {
        $like_id = \request()->like_id;
        Like::where('id', $like_id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'success',
            'data' => null
        ]);
    }
}
