<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Blog extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'title','description','image',
        'date_to_publish','status','user_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
