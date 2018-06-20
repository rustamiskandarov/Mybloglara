<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Comment extends Model
{
    use Sluggable;
    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
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
