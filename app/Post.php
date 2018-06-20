<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Support\Facades\Storage;

class Post extends Model
{
    use Sluggable;
    protected $fillable = ['title', 'content'];

    public function category()
    {
        return $this->hasOne(Category::class);
    }

    public function author()
    {
        return $this->hasOne(User::class);
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
        Storage::delete('uploads/'. $this->image);//удаляет существующий файл
        $this->delete();
    }

    public function uploadImage($image)
    {
        if($image ==null) {return;}; //если image пустой то выходим из функции
        Storage::delete('uploads/'. $this->image);//удаляет существующий файл
        $filename = str_random(10).'.'.$image->extension();//гинирирует имя файла
        $image->saveAs('upload', $filename);//сохраняет файл на диск
        $this->image = $filename;//сохраняет название файла в БД
        $this->save();
    }

    public function setCategory($id)
{
    if($id ==null){return;};
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
        $this->id_featured = 1;
        $this->save();
    }

    public function setStandart()
    {
        $this->id_featured = 0;
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
            return '/img/no-imge.png';
        }

        return '/uploads/'. $this->image;
    }
}
