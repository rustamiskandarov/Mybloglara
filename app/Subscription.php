<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public static function add($email)
    {
        $sub = new static; //создаём экземпляр данного класса
        $sub->email = $email; //присваеваем полю значение
        $sub->token = str_random(100); //генерируем токен
        $sub->save();

        return $sub;
    }

    public function remove()
    {
        $this->delete();
    }
}
