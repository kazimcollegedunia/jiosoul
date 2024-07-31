<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChild extends Model
{
    use HasFactory;
    public $timestamps = false;

     // Define the parent relationship
     public function parent()
     {
         return $this->belongsTo(User::class, 'parent_id');
     }
 
     // Define the child relationship
     public function child()
     {
         return $this->belongsTo(User::class, 'child_id');
     }
}
