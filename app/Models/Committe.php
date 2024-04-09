<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Committe extends Model
{
    use HasFactory;
    protected $table = 'committes';
    protected $fillable = ['committe'];    
    public $timestamps = true;

    public function directories()
    {
        return $this->belongsToMany(Directory::class, 'committe_id');
    }
}
