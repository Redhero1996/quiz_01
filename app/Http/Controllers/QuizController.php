<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Category;
use App\Models\Question;
use App\Models\Topic;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function category($category_id)
    {
        $topics = Topic::where('category_id', $category_id)->latest('id')->get();
        foreach ($topics as $key => $topic) {
            $topics[$key]['count'] = count($topic->questions);
        }
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
            'F', 'G', 'H', 'I', 'J',
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

    public function handleQuestion(Request $request)
    {
        $dataRequest = $request->dataRequest;
        $topic_id = $dataRequest[0]['topic'];
        $score = config('constants.zero');
        $total = config('constants.zero');
        $correct = [];
        $answered = [];
        foreach ($dataRequest as $key => $value) {
            $question = Question::findOrFail($value['question_id']);
            if (isset($value['answered'])) {
                $value['answered'] = array_map(function ($elem) {
                    return intval($elem);
                }, $value['answered']);
                $answered[$key] = $value['answered'];
                if ((count($value['answered']) == count($question->correct_ans)) && !array_diff($value['answered'], $question->correct_ans)) {
                    $score++;
                    $total += config('constants.point');
                    $correct[] = [
                        'question_id' => $value['question_id'],
                        'answered' => $value['answered'],
                        'answer' => true,
                    ];
                } else {
                    $correct[] = [
                        'question_id' => $value['question_id'],
                        'answered' => $value['answered'],
                        'answer' => false,
                        'correct_ans' => $question->correct_ans,
                    ];
                }
            } else {
                $correct[] = [
                    'question_id' => $value['question_id'],
                    'answered' => config('constants.negative'),
                    'answer' => false,
                    'correct_ans' => $question->correct_ans,
                ];
            }
        }
        $answered = json_encode($answered);

        // Save total and user's answer
        Auth::user()->topics()->attach($topic_id, ['total' => $total, 'answered' => $answered]);

        // Data response
        $dataResponse = [
            'score' => $score,
            'total' => $total,
            'correct' => $correct,
        ];

        return $dataResponse;
    }

    public function reviewQuiz($category_slug, $topic_slug, $id)
    {
        $alphabet = [
            'A', 'B', 'C', 'D', 'E',
            'F', 'G', 'H', 'I', 'J',
            'K', 'L', 'M', 'N', 'O',
            'P', 'Q', 'R', 'S', 'T',
            'U', 'V', 'W', 'X', 'Y',
            'Z',
        ];
        $topic = Topic::whereSlug($topic_slug)->first();
        $questions = $topic->questions()->where('topic_id', $topic->id)->get();
        $data = [];
        foreach ($topic->users as $key => $user) {
            $answered = json_decode($user->pivot->answered, true);
            if ($user->pivot->id == $id) {
                $data['total'] = $user->pivot->total;
                foreach ($questions as $key => $question) {
                    $answers = Answer::where('question_id', $question->id)->get();
                    foreach ($answered as $k => $answer) {
                        if ($key == $k) {
                            $data['topic'][$key] = [
                                'question' => $question,
                                'answers' => $answers,
                                'answered' => $answer,
                            ];
                            break;
                        } else {
                            $data['topic'][$key] = [
                                'question' => $question,
                                'answers' => $answers,
                            ];
                        }
                    }
                }
            }
        }

        return view('pages.review', compact('topic', 'data', 'alphabet'));
    }
}
