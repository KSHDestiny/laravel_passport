<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['name','user_id','email','age','phone','address','position'];

    public function user(){
        return $this->belongsTo(User::class,'user_id','id');
    }
}
