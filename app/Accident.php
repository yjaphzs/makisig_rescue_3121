<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Accident extends Model
{
    protected $fillable = ['date','time','place','accident','involves','remarks','responders'];

}
