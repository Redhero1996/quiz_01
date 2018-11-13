<?php

namespace App\Http\Controllers;

use App\Http\Requests\HandleCreateTopicRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Question;
use App\Models\Topic;
use App\Models\Answer;
use App\User;
use Session;
use Purifier;
use App\Repositories\Repository;
use App\Repositories\GeneralRepository;

class UserCreateTopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;

    public function __construct(GeneralRepository $repository) {
        $this->repository = $repository;
    }

    public function index(User $user)
    {
        $topics = Topic::where('user_id', $user->id)->get();

        return view('pages.topics.manage-topic', compact('topics'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $alphabet = $this->repository->getAlphabet();
        $categories = Category::all();

        return view('pages.topics.create-topic', compact('categories', 'alphabet'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HandleCreateTopicRequest $request)
    {
        $topic = Topic::create([
            'name' => $request->topic_name,
            'slug' => str_slug($request->topic_name, '-'),
            'category_id' => $request->category_id,
            'user_id' => Auth::user()->id,
            'status' => 0,
            'view_count' => 0,
        ]);
        foreach ($request->content as $key => $question) {
            foreach ($request->explain[$key] as $explain) {
                $question = Question::create([
                    'content' => Purifier::clean($question),
                    'explain' => Purifier::clean($explain),
                ]);
                $question->topics()->sync($topic->id, false);
            }
            $corrected = $question->correct_ans;
            $correct = $request->correct_ans[$key];
            foreach ($request->answer[$key] as $k => $content) {
                $answer = Answer::create([
                    'question_id' => $question->id,
                    'content' => $content,
                ]);
                $answer->question()->associate($question->id);
                for ($i = 0; $i < count($correct); $i++) {
                    if ($k == (int) $correct[$i]) {
                        $corrected[$i] = $answer->id;
                        $question->correct_ans = $corrected;
                    }
                    $question->save();
                }
            }
        }
        Session::flash('success', __('translate.request'));

        return redirect()->route('create-topics.index', $topic->user_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category, Topic $topic, $id)
    {
    	$alphabet = $this->repository->getAlphabet();
        $questions = $topic->questions()->get();

        return view('pages.topics.show-topic', compact('category', 'topic', 'questions', 'alphabet'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $alphabet = $this->repository->getAlphabet();
        $categories = Category::all();
        $topic = Topic::findOrFail($id);
        $questions = $topic->questions()->get();

        return view('pages.topics.edit-topic', compact('categories', 'topic', 'questions', 'alphabet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HandleCreateTopicRequest $request, $id)
    {
        $topic = Topic::findOrFail($id);
        if ($topic->name != $request->topic_name) {
            $topic->name = $request->topic_name;
            $topic->slug = str_slug($request->topic_name);
            $topic->category_id = $request->category_id;
            $topic->save();          
        }
        $questions = $topic->questions()->get();
        foreach ($questions as $key => $question) {
            $question->correct_ans = null;
            $correct = $question->correct_ans;
            $question->content = Purifier::clean($request->content[$question->id]);
            $question->explain = Purifier::clean($request->explain[$question->id][0]);
            for ($i = 0; $i < count($request->correct_ans[$question->id]); $i++) {
                $correct[$i] = (int) $request->correct_ans[$question->id][$i];
                $question->correct_ans = $correct;
            }
            $question->save();
            $question->topics()->sync($topic->id);
            // Update all answers was be change
            $answers = Answer::where('question_id', $question->id)->get();
            $all_ans = $request->answer[$question->id];
            for ($i = 0; $i < count($all_ans); $i++) {
                $answer = Answer::find($answers[$i]->id);
                if ($all_ans[$i] != $answers[$i]->content) {
                    $answer->content = $all_ans[$i];
                    $answer->save();
                }
            }
        }
        Session::flash('success', __('translate.topic_updated'));

        return redirect()->route('create-topics.show', [$topic->category->slug, $topic->slug, $topic->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);
        foreach ($topic->questions()->get() as $question) {
            $answer = Answer::where('question_id', $question->id)->delete();
            $question->topics()->detach();
            $question->delete();
        }
        $topic->delete();
        Session::flash('success', __('translate.topic_deleted'));
        
        return redirect()->route('create-topics.index', Auth::user()->id);
    }
}
