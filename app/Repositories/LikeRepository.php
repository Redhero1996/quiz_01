<?php 
namespace App\Repositories;

use App\Models\Like;

class LikeRepository extends Repository {
    function model()
    {
        return new Like();
    }

    public function getDataResponse($like, $isLike, $likeCount, $dislikeCount) {
        return [
            'like' => $like,
            'isLike' => $isLike,
            'like_count' => $isLike,
            'dislike_count' => $dislikeCount,
        ];
    }
}
