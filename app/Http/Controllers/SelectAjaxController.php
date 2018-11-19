<?php

namespace App\Http\Controllers;

use App\Models\Topic;

class SelectAjaxController extends Controller
{
    public function select($category_id)
    {
        $topics = Topic::where('category_id', $category_id)->latest('id')->get(
            [
                'id',
                'name',
            ]
        );

        return response()->json($topics);
    }
}
