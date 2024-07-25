<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AmountCollection extends Model
{

    const PENDING = 0; 
    const APPROVE = 1; 
    const REJECTED = 2; 

    use HasFactory;

    public function userDetails()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
}
