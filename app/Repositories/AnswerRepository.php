<?php 

namespace App\Repositories;

use App\Answer;

class AnswerRepository extends Repository {
    function model()
    {
        return new Answer();
    }
}
