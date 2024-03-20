<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Requests\Admin\GameRequest;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) {
            return view('admin.games.index');
        }

        $games = Game::query();

        return Game::dataTable($games);
    }

    public function create()
    {
        return view('admin.games.create');
    }

    public function store(GameRequest $request)
    {
        $input = $request->validated();
        $game = Game::create($input);
        $game->addAttachment($input['thumbnail'], 'thumbnail');
        $game->addAttachment($input['esbr_image'], 'esbr_image');

        return $this->jsonSuccess('Game created successfully', [
            'redirect' => route('admin.games.index')
        ]);
    }

    public function edit(Game $game)
    {
        return view('admin.games.edit', compact('game'));
    }

    public function update(GameRequest $request, Game $game)
    {
        $input = $request->validated();

        $game->update($input);
        $game->addAttachment($input['thumbnail']??null, 'thumbnail');
        $game->addAttachment($input['esbr_image']??null, 'esbr_image');

        return $this->jsonSuccess('Game updated successfully');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return $this->jsonSuccess('Game deleted successfully');
    }
}
