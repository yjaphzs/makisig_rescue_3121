<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Involve extends Model
{
    protected $table = 'involves';

    public $primaryKey = 'incidentID';

    public function incident(){
        return $this->belongsTo('App\Incident');
    }
}
