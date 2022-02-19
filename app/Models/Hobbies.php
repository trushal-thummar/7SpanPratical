<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hobbies extends Model
{
	protected $fillable = ['title'];

	//Get Hobbies User List Based On Pivot Table
    public function users(){
        return $this->belongsToMany(User::class, 'hobbies_user', 'user_id');
    }
}
