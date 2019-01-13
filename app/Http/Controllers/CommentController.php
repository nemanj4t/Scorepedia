<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\Redis;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
                'name' => 'required',
                'content' => 'required'
            ]);
        $now = date('YmdHis');

        $comment = new Comment($request['name'], $request['content'], $now);
        $comment->save($id);

        return redirect()->back();
    }

    public function destroy(Request $request, $id)
    {
        Redis::zrem('match:'.$id.':comments', $request->id);
        Redis::decr('count:comments');
        return redirect()->back()->with('danger', 'Comment deleted!');
    }

}
