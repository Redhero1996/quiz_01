<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;

class QuizController extends Controller
{
    public function category($category_id)
    {
        $topics = Topic::where('category_id', $category_id)->latest('id')->get(
            [
                'id',
                'name',
                'created_at',
            ],
        );

        return response()->json($topics);
    }
}
