<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * @param $fields
     * @return static
     * работа с пользователем
     */
    public function add($fields)
    {
        $user = new static;
        $user->fill($fields);
        $user->password = bcrypt($fields['password']);
        $user->save();

        return $user;
    }

    public function edit($fields)
    {
        $this->fill($fields);
        $this->password = bcrypt($fields['password']);
        $this->save();
    }

    public function remove()
    {
        $this->delete();
    }

    /**
     * @param $image
     * работа с изображением
     */
    public function uploadAvatar($image)
    {
        if($image ==null) {return;}; //если image пустой то выходим из функции
        Storage::delete('uploads/'. $this->image);//удаляет существующий файл
        $filename = str_random(10).'.'.$image->extension();//гинирирует имя файла
        $image->saveAs('upload', $filename);//сохраняет файл на диск
        $this->image = $filename;//сохраняет название файла в БД
        $this->save();
    }

    public function getAvatar()
    {
        if($this->image == null){
            return '/img/default-avatar.png';
        }

        return '/uploads/'. $this->image;
    }

    /**
     * назначить или убрать роль админ
     */
    public function makeAdmin()
    {
        $this->is_admin = 0;
        $this->save();
    }

    public function makeNormal()
    {
        $this->is_admin = 1;
        $this->save();
    }

    public function toggleAdmin($value)
    {
        if($value == null){
            return $this->makeNormal();
        }
        return $this->makeAdmin();
    }

    /**
     * забанить или разбанить пользователя
     */

    public function ban()
    {
        $this->status = 1;
        $this->save();
    }

    public function unban()
    {
        $this->status = 0;
        $this->save();
    }

    public function toggleBan($value)
    {
        if($value == null){
            return $this->unban();
        }
        return $this->ban();
    }


}
