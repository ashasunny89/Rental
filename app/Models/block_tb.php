<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class block_tb extends Model
{
    use HasFactory;
    protected $table='block';
    protected $fillable=['id','name','parent_id','president','phone'];
}