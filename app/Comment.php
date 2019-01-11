<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class Comment
{
    public $id;
    public $publisher;
    public $content;
    public $timestamp;

    public function __construct($publisher, $content, $timestamp)
    {
        $this->id = $publisher.':'.$content;
        $this->publisher = $publisher;
        $this->content = $content;
        $this->timestamp = $timestamp;
    }

    public function save($id)
    {
        Redis::zadd('match:'.$id.':comments', $this->timestamp, $this->id);
    }

    public static function getAllCommentsByMatchId($id)
    {
        $rediscomments = Redis::zrevrange('match:'.$id.':comments', 0, -1, 'WITHSCORES');
        $comments = [];

        foreach($rediscomments as $key => $rcomment) {
            $data = explode(':', $key);
            $comment = new Comment($data[0], $data[1], $rcomment);

            $comments[] = $comment;
        }

        return $comments;
    }
}
