<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fabelio extends Model
{
    protected $fillable = ['title', 'url', 'description', 'images'];
}
