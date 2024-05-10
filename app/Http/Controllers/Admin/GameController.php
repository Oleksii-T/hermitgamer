<?php

namespace App\Http\Controllers\Admin;

use App\Models\Game;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Actions\GenerateSitemap;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GameRequest;

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
        $input['summary'] = sanitizeHtml($input['summary']);
        $game = Game::create($input);
        $game->addAttachment($input['thumbnail'], 'thumbnail');
        $game->addAttachment($input['esbr_image'], 'esbr_image');
        $game->addAttachment(Attachment::formatMultipleRichInputRequest($input['screenshots']??[]), 'screenshots');

        Game::getAllSlugs(true);
        GenerateSitemap::run();

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

        $input['summary'] = sanitizeHtml($input['summary']);
        $game->update($input);
        $game->addAttachment($input['thumbnail']??null, 'thumbnail');
        $game->addAttachment($input['esbr_image']??null, 'esbr_image');
        $game->addAttachment(Attachment::formatMultipleRichInputRequest($input['screenshots']??[]), 'screenshots');

        Game::getAllSlugs(true);
        GenerateSitemap::run();

        return $this->jsonSuccess('Game updated successfully');
    }

    public function destroy(Game $game)
    {
        $game->delete();

        return $this->jsonSuccess('Game deleted successfully');
    }
}
