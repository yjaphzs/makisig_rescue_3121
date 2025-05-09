<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $fillable = ['last_name','first_name','middle_initial','gender','barangay'];
}
