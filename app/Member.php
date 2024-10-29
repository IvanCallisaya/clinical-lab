<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;



    // relation with role 

    public function customer()
    {

        return $this->belongsTo('App\Customer');
    }

    public function user(){

    	return $this->belongsTo('App\User');
    }
}
