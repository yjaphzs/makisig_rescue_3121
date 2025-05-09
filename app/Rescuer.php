<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rescuer extends Model
{
    protected $fillable = ['last_name','first_name','middle_initial','gender','contact'];
}
