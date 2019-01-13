<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/10/2019
 * Time: 9:54 PM
 */

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Article;
use App\Team;
use App\Coach;
use App\Player;

class ArticleController extends Controller
{
    public function show($id)
    {
        $article = Article::getById($id);

        if(!$article) {
            return abort('404');
        }

        return view('articles.show', compact('article'));
    }

    public function create()
    {
        $players = Player::getAllWithCurrentTeam();
        $teams = Team::getTeams();
        $coaches = Coach::getAll();

        return view('articles.create', compact('players', 'teams', 'coaches'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'title' => 'required',
           'image' => 'required' ,
           'content' => 'required'
        ]);

        Article::saveArticle($request);

        return redirect('/apanel/articles')->with('success', 'Added new article');
    }

    public function destroy($id)
    {
        Article::deleteArticle($id);

        return redirect('/apanel/articles')->with('danger', 'Article deleted');
    }
}