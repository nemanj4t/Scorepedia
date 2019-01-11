<?php
/**
 * Created by PhpStorm.
 * User: vtmr
 * Date: 1/10/2019
 * Time: 9:54 PM
 */

namespace App\Http\Controllers;
use App\Article;

class ArticleController extends Controller
{
    public function index()
    {
    }

    public function show($id)
    {
        $article = Article::getById($id);

        dd($article);
    }

    public function create()
    {
        return view('articles.create');
    }

    public function store(Request $request)
    {
        Article::saveArticle($request);

        return redirect('/articles');
    }

    public function destroy($id)
    {
        $deleted = Article::deleteArticle($id);
        ($deleted > 0) ? $success = true : $success = false;

        return redirect('/articles');
    }
}