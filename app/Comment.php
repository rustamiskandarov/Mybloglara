<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class); //пост имеет множество коментариев
    }

    public function author()
    {
        return $this->belongsTo(User::class); //автор иммеет множество комментариев
    }

    /**
     * разрешен или запрещён к бубликации комментарий
     */
    public function allow()
    {
        $this->status = 1;
        $this->save();
    }

    public function disAllow(){
        $this->status = 0;
        $this->save();
    }

    public function toggleStatus()
    {
        if($this->status = 0){
            $this->allow();
        }

        $this->disAllow();
    }

    public function remove()
    {
        $this->delete();
    }
}
