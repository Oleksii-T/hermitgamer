<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Post;
use App\Models\Author;
use App\Models\Feedback;
use App\Enums\PageStatus;
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
        $latestLists = (clone $q)->whereRelation('category', 'slug', 'lists')->limit(2)->get();
        $latestNews = (clone $q)->whereRelation('category', 'slug', 'news')->limit(2)->get();
        $authors = Author::get(); 

        return view('index', compact('page', 'authors', 'latestReviews', 'latestGuides', 'latestNews', 'latestLists'));
    }

    public function show(Request $request)
    {
        $page = Page::query()
            ->where('link', \Request::path())
            ->where('status', PageStatus::PUBLISHED)
            ->firstOrFail();

        return view('page', compact('page'));
    }

    public function search(Request $request)
    {
        $s = $request->search;
        $posts = Post::query()
            ->publised()
            ->where(fn ($q) => $q
                ->where('title', 'like', "%$s%")
                ->orWhere('intro', 'like', "%$s%")
                ->orWhere('conclusion', 'like', "%$s%")
                ->orWhereRelation('game', 'name', 'like', "%$s%")
                ->orWhereHas('blocks', fn ($qq) => $qq->whereRelation('items', 'value', 'like', "%$s%"))
            )
            ->paginate(6);
        $hasMore = $posts->hasMorePages();

        if (!$request->ajax()) {
            $page = Page::get('search');
            return view('search', compact('page', 'posts', 'hasMore'));
        }

        return $this->jsonSuccess('', [
            'hasMore' => $hasMore,
            'html' => view('components.post-cards', compact('posts'))->render()
        ]);
    }

    public function rate()
    {
        $page = Page::get('how-we-review');
        $blocks = $page->blocks->sortBy('order');

        return view('rate', compact('page', 'blocks'));
    }

    public function contactUs(Request $request)
    {
        if (!$request->ajax()) {
            $page = Page::get('contact');
            
            return view('contact-us', compact('page'));
        }

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
        $input['ip'] = $request->ip();

        Feedback::create($input);

        return $this->jsonSuccess('Message send');
    }

    public function privacy()
    {
        $page = Page::get('privacy-policy');
        $blocks = $page->blocks->sortBy('order');

        return view('privacy', compact('page', 'blocks'));
    }

    public function terms()
    {
        $page = Page::get('terms-of-service');
        $blocks = $page->blocks->sortBy('order');

        return view('terms', compact('page', 'blocks'));
    }

    public function aboutUs()
    {
        $page = Page::get('about');
        $authors = Author::get();
        $blocks = $page->blocks->sortBy('order');

        return view('about-us', compact('page', 'authors', 'blocks'));
    }
}
