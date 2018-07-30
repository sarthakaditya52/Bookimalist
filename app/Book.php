<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    public function attributes(){
        return $this->hasMany('App\BookAttributes','book_id');
    }
}
