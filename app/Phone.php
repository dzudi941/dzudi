<?php

namespace App;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;

class Phone extends NeoEloquent
{

    protected $label = 'Phone';
    protected $fillable = ['code', 'number'];

     public function actor()
    {
        return $this->belongsTo('App\Settings');
    }

}
