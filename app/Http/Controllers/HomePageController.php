<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Topic;
use Illuminate\Support\Facades\Auth;
use Session;

class HomePageController extends Controller
{
    public function home()
    {
        $categories = Category::all();
        $topics = Topic::paginate();

        return view('pages.homepage', compact('categories', 'topics'));
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }
}
