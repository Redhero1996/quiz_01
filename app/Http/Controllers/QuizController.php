<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;

class QuizController extends Controller
{
    public function category($category_id)
    {
        $topics = Topic::where('category_id', $category_id)->latest('id')->get();
        $category = Category::whereId($category_id)->get();

        return response()->json([
            'topics' => $topics,
            'category_slug' => $category[0]['slug'],
        ]);
    }

    public function quiz($category_slug, $topic_slug)
    {
        $alphabet = [
            'A', 'B', 'C', 'D', 'E',
            'F', 'G', 'H', 'I', 'K',
            'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y',
            'Z',
        ];
        $topic = Topic::whereSlug($topic_slug)->first();
        $questions = $topic->questions()->where('topic_id', $topic->id)->get();
        $data = [];
        foreach ($questions as $key => $question) {
            $answers = Answer::where('question_id', $question->id)->get();
            $data[$key] = [
                'question' => $question,
                'answers' => $answers,
            ];
        }

        return view('pages.quiz', compact('topic', 'data', 'alphabet'));
    }
}
