<?php 

namespace App\Repositories;

use App\Topic;

class TopicRepository extends Repository {
    function model()
    {
        return new Topic();
    }
}
