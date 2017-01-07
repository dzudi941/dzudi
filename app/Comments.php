<?php

namespace App;

use Vinelab\NeoEloquent\Eloquent\Model as NeoEloquent;
use App\User;

class Comments extends NeoEloquent
{
    protected $label = 'Comments';

    protected $fillable = ['comment', 'likes', 'dislikes'];


    public function BelongsToUser()
    {
    	return $this->belongsTo('App\User', 'ChildCommentOfUser');
    }
    public function HasComments()
    {
    	return $this->hasMany('App\Comments', 'ChildComments');
    }
    public function BelongsToComment()
    {
    	return $this->belongsTo('App\Comments', 'ChildComments');
    }
    public function BelongsToUserLike()
    {
        return $this->belongsTo('App\User', 'ChildLikeOfUser');
    }
    public function BelongsToUserDisLike()
    {
        return $this->belongsTo('App\User', 'ChildDisLikeOfUser');
    }
}
