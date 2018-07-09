<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;
    protected $fillable = ['title', 'content', 'date'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
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
        $post->user_id = 1;
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
}
