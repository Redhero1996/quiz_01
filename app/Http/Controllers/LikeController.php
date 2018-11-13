<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Topic;
use App\Models\Like;
use Session;
use App\Repositories\LikeRepository;

class LikeController extends Controller
{
    protected $likeRepo;

    public function __construct(LikeRepository $likeRepo) {
        $this->likeRepo = $likeRepo;
    }

    public function likeTopic(Request $request)
    {
        $topic_id = $request->topic_id;
        $liked = (int)$request->like;    
        $topic = Topic::findOrFail($topic_id);
        $user = Auth::user();
        $liker = $user->likes()->where('topic_id', $topic_id)->firstOrFail();
        $likeCount = count($topic->likes()->where('status', 1)->get());
        $dislikeCount = count($topic->likes()->where('status', 0)->get());
        if ($liker) {
            if ($liker->status == $liked) {
                $liker->delete();
                $dataResponse = $this->likeRepo->getDataResponse($liked, false, $likeCount, $dislikeCount);
            } else {
                $liker->status = $liked;
                $liker->save();
                $dataResponse = $this->likeRepo->getDataResponse($liked, true, $likeCount, $dislikeCount);
            }
        } else {
            $like = new Like();
            $like->user_id = $user->id;
            $like->topic_id = $topic->id;
            $like->status = $liked;
            $like->user()->associate($user->id);
            $like->topic()->associate($topic->id);
            $like->save();
            $dataResponse = $this->likeRepo->getDataResponse($liked, true, $likeCount, $dislikeCount);
        }

        return $dataResponse;
    }
}
