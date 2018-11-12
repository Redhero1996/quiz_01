<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfileRequest;
use App\Models\Category;
use App\Models\Topic;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Image;
use Session;
use Storage;
use App\Repositories\Repository;

class HomePageController extends Controller
{
    protected $rank;
    protected $category;

    public function __construct(Category $category) {
        $this->category = new Repository($category);
    }
    
    public function home()
    {
        $categories = $this->category->all();
        $topics = Topic::latest('id')->where('status', 1)->paginate();
        $ranks = [];
        $select_table = DB::select(
            'select user_id, avg(max_score) as score, count(topic_id) as count_topic
            from ( select user_id, topic_id, max(total) as max_score
                    from topic_user
                    group by user_id, topic_id
                ) as tmp
            group by user_id
            order by score desc;'
        );
        foreach ($select_table as $key => $select) {
            foreach (Topic::all() as $topic) {
                foreach ($topic->users as $user) {
                    if ($select->user_id == $user->id) {
                        $ranks[$key]['username'] = $user->name;
                        $ranks[$key]['avatar'] = $user->avatar;
                        $ranks[$key]['total'] = $select->score;
                        $ranks[$key]['count'] = $select->count_topic;
                    }
                }
            }
        }

        return view('pages.homepage', compact('categories', 'topics', 'ranks'));
    }

    public function getProfile($username, $id)
    {
        $user = User::findOrFail($id);

        return view('pages.profile', compact('user'));
    }

    public function postProfile(UserProfileRequest $request, $username, $id)
    {
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone_number = $request->phone_number;
        $user->address = $request->address;
        if ($request->change_password == 'on') {
            $user->password = bcrypt($request->password);
        }
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $file_name = time() . '.' . $avatar->getClientOriginalExtension();
            $location = public_path('images/' . $file_name);
            Image::make($avatar)->resize(300, 300)->save($location);
            if (isset($user->avatar)) {
                $old_avatar = $user->avatar;
                $user->avatar = $file_name;
                Storage::delete($old_avatar);
            } else {
                $user->avatar = $file_name;
            }
        }
        $user->save();
        Session::flash('success', trans('translate.succ_acount'));

        return redirect()->route('user.profile', [$user->name, $user->id]);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }
}
