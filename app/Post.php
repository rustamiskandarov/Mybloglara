<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;
    protected $fillable = ['title', 'content', 'date', 'description'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class,
            'post_tags',
            'post_id',
            'tag_id'
        );
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

    public static function add($fields)
    {
        $post = new static;
        $post->fill($fields);
        $post->user_id = Auth::user()->id;
        $post->save();

        return $post;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    public function remove()
    {
        $this->removeImage();
        $this->delete();
    }

    public function uploadImage($image)
    {
        if($image ==null) {return;}; //если image пустой то выходим из функции

        $this->removeImage();
        $filename = str_random(10).'.'.$image->extension();//гинирирует имя файла
        $image->storeAs('uploads', $filename);//сохраняет файл на диск
        $this->image = $filename;//сохраняет название файла в БД
        $this->save();
    }

    protected function removeImage()
    {
        if($this->image != null){
            Storage::delete('uploads/'. $this->image);//удаляет существующий файл
        }
    }

    public function setCategory($id)
    {
    if($id == null){return;};
    $this->category_id = $id;
    $this->save();
    }

    public function setTags($ids)
    {
        if($ids == null){return;};
        $this->tags()->sync($ids); // присвоение тегов через Laravel связи, синхронизируем статью с тегами id которых = $ids, а предыдущие id тегов в статье удаляться
    }

    public function setDraft()
    {
        $this->status = 0; //можно поставить Post::IS_DRUFT и обявить в начале метода константу IS_DRUFT;
        $this->save();
    }

    public function setPublic()
    {
        $this->status = 1; //можно поставить Post::IS_PUBLIC и обявить в начале метода константу IS_PUBLIC;
        $this->save();
    }

    public function toggleStatus($value)
    {
        if($value == null){
            return $this->setDraft();
        }

        return $this->setPublic();
    }

    public function setFeatured()
    {
        $this->is_featured = 1;
        $this->save();
    }

    public function setStandart()
    {
        $this->is_featured = 0;
        $this->save();
    }

    public function toggleFeatured($value)
    {
        if($value == null){
            return $this->setStandart();
        }

        return $this->setFeatured();
    }

    public function getImage()
    {
        if($this->image == null){
            return '/img/no-image.png';
        }

        return '/uploads/'. $this->image;
    }

    public function getCategoryTitle()
    {
        return ($this->category != null) ? $this->category->title : "без категории";
    }

    public function getTagsTitles()
    {
        return (!$this->tags->isEmpty())
            ? implode(', ', $this->tags->pluck('title')->all())
            : 'Нет тегов';
    }

    public function setDateAttribute($value)
    {
        $date = Carbon::createFromFormat('d/m/y', $value)->format('Y-m-d');
        $this->attributes['date'] = $date;
    }

    public function getDateAttribute($value)
    {
        $date = Carbon::createFromFormat('Y-m-d', $value)->format('d/m/y');
        return $date;
    }

    public function geDate()
    {
        $date = Carbon::createFromFormat('d/m/y', $this->date)->format('F d, Y');
        return $date;
    }

    public function hasPrevious()
    {
        return self::where('id', '<', $this->id)->max('id');
    }

    public function getPrevious()
    {
        $postID = $this->hasPrevious();
        return self::find($postID);
    }

    public function hasNext()
    {
        return self::where('id', '>', $this->id)->min('id');
    }

    public function getNext()
    {
        $postID = $this->hasNext();
        return self::find($postID);
    }

    public function realeted()
    {
        return self::all()->except($this->id);
    }

    public function hasCategory()
    {
        return ($this->category != null) ? true : false;
    }

    public function hasTags()
    {
        return ($this->tags != null) ? true : false;
    }

    public static function getPopularPosts()
    {
        return self::orderBy('views', 'desc')->take(3)->get();
    }

    public static function getFeaturedPosts()
    {
        return self::where('is_featured', 1)->take(3)->get();
    }

    public static function getRecentPosts()
    {
        return self::orderBy('date', 'desc')->take(4)->get();
    }

    public function getComments()
    {
        return $this->comments()->where('status', 1)->get();
    }

}
