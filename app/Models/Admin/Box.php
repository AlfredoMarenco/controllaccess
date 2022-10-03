<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function codes(){
        return $this->hasMany(Code::class);
    }
}
