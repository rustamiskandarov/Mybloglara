<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    public static function add($email)
    {
        $sub = new static; //создаём экземпляр данного класса
        $sub->email = $email; //присваеваем полю значение
        $sub->save();

        return $sub;
    }

    public function generateToken()
    {
        $this->token = str_random(100); //генерируем токен
    }

    public function getStatus()
    {
        return ($this->token == null)? 'Потверждён' : 'Не потверждён';
    }
    public function remove()
    {
        $this->delete();
    }
}
