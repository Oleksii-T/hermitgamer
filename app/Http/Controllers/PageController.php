<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Author;
use App\Models\Feedback;
use App\Models\FeedbackBan;
use Illuminate\Http\Request;
use App\Enums\FeedbackStatus;

class PageController extends Controller
{
    public function index()
    {
        $page = Page::get('/');
        $q = Post::publised()->latest();
        $latestReviews = (clone $q)->whereRelation('category', 'slug', 'reviews')->limit(3)->get();
        $latestGuides = (clone $q)->whereRelation('category', 'slug', 'guides')->limit(2)->get();
        $latestNews = (clone $q)->whereRelation('category', 'slug', 'top-lists')->limit(2)->get();
        $authors = Author::get();

        return view('index', compact('page', 'authors', 'latestReviews', 'latestGuides', 'latestNews'));
    }

    public function rate()
    {
        $page = Page::get('rate');

        return view('rate', compact('page'));
    }

    public function contactUs()
    {
        $page = Page::get('contact-us');

        return view('contact-us', compact('page'));
    }

    public function feedback(Request $request)
    {
        $input = $request->validate([
            'subject' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'text' => ['required', 'string', 'max:2000']
        ]);

        $user = auth()->user();
        $ban = $user ? FeedbackBan::where('type', 'user')->where('value', $user->id)->first() : null;
        $ban ??= FeedbackBan::where('type', 'ip')->where('value', $request->ip())->first();
        $ban ??= FeedbackBan::where('type', 'name')->where('value', $input['name'])->first();
        $ban ??= FeedbackBan::where('type', 'email')->where('value', $input['email'])->first();

        if ($ban && $ban->is_active) {
            if ($ban->action == 'abort') {
                abort(429);
            } else if ($ban->action == 'spam') {
                $input['status'] = FeedbackStatus::SPAM;
            }
        }

        $input['user_id'] = $user->id??null;

        Feedback::create($input);

        return $this->jsonSuccess('Message send');
    }

    public function privacy()
    {
        $page = Page::get('privacy');

        return view('privacy', compact('page'));
    }

    public function terms()
    {
        $page = Page::get('terms');

        return view('terms', compact('page'));
    }

    public function aboutUs()
    {
        $page = Page::get('about-us');

        return view('about-us', compact('page'));
    }
}
