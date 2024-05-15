<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Page;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function show(Request $request, Game $game)
    {
        $perPage = 4;
        $guides = $game->posts()
            ->publised()
            ->whereHas('category', fn ($q) => $q->whereIn('slug', ['guides', 'cheats']))
            ->latest()
            ->paginate($perPage);
        $topLists = $game->posts()
            ->publised()
            ->whereHas('category', fn ($q) => $q->whereIn('slug', ['top-lists', 'mods']))
            ->latest()
            ->paginate($perPage);

        if (!$request->ajax()) {
            $page = Page::get('{game}');
            $review = $game->posts()->publised()->whereRelation('category', 'slug', 'reviews')->latest()->first();
            $hasMoreGuides = $guides->hasMorePages();
            $hasMoreTopLists = $topLists->hasMorePages();

            return view('games.show', compact('page', 'game', 'review', 'guides', 'topLists', 'hasMoreGuides', 'hasMoreTopLists'));
        }

        if ($request->type == 'guides') {
            return $this->jsonSuccess('', [
                'hasMore' => $guides->hasMorePages(),
                'html' => view('components.post-cards-small', ['posts' => $guides])->render()
            ]);
        }
        
        if ($request->type == 'top_lists') {
            return $this->jsonSuccess('', [
                'hasMore' => $topLists->hasMorePages(),
                'html' => view('components.post-cards-small', ['posts' => $topLists])->render()
            ]);
        }

    }
}
