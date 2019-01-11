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
        Article::save();
    }
}