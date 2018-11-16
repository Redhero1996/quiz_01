<?php 

namespace App\Repositories;

use App\Comment;

class CommentRepository extends Repository {
    function model()
    {
        return new Comment();
    }
}
