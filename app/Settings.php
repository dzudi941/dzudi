<?php

namespace App;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use App\Phone;

class Settings extends NeoEloquent   
{
    
    protected $label = 'Actor';

     protected $fillable = ['name', 'email'];

     public function phone()
    {
        return $this->hasOne('App\Settings');
    }
}
