<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GroupPosts;

class GPComment extends Model
{
	protected $guarded = [];

    public function group_post()
    {
    	return $this->belongsTo(GroupPosts::class);
    }
}
