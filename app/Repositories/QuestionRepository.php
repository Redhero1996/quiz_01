<?php 

namespace App\Repositories;

use App\Question;

class QuestionRepository extends Repository {
    function model()
    {
        return new Question();
    }
}
