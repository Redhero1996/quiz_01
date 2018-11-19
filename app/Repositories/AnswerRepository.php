<?php 

namespace App\Repositories;

use App\Answer;

namespace App\Repositories;

use App\Models\Anwser;

class AnswerRepository extends Repository {
    function model()
    {
        return new Anwser();
    }
}
