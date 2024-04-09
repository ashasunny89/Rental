<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directory extends Model
{
    use HasFactory;
    protected $table = 'directories';
    protected $fillable = ['committe_id','positionname', 'name', 'image', 'address', 'phone', 'email','priority'];    
    public $timestamps = true;

    public function Committe()
    {
        return $this->belongsTo(Committe::class);
    }
}
