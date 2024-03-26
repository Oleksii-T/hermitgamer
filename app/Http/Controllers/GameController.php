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
        $guides = $game->posts()->whereRelation('category', 'slug', 'guides')->latest()->paginate($perPage);

        if (!$request->ajax()) {
            $page = Page::get('post');
            $review = $game->posts()->whereRelation('category', 'slug', 'reviews')->latest()->first();
            $guides = $game->posts()
                ->whereHas('category', fn ($q) => $q->whereIn('slug', ['guides', 'cheats']))
                ->latest()
                ->paginate($perPage);
            $hasMoreGuides = $guides->hasMorePages();
            $topLists = $game->posts()
                ->whereHas('category', fn ($q) => $q->whereIn('slug', ['top-lists', 'mods']))
                ->latest()
                ->limit(2)
                ->get();

            return view('games.show', compact('page', 'game', 'review', 'guides', 'topLists', 'hasMoreGuides'));
        }

        return $this->jsonSuccess('', [
            'hasMore' => $guides->hasMorePages(),
            'html' => view('components.post-cards-small', ['posts' => $guides])->render()
        ]);
    }
}
