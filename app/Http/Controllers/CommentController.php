<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Comment;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
                'name' => 'required',
                'content' => 'required'
            ]);
        $now = date('dmyhis');

        $comment = new Comment($request['name'], $request['content'], $now);
        $comment->save($id);

        return redirect()->back();
    }
}
