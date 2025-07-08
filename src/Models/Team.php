<?php

namespace Alaa\TaskManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Team extends Model
{
    protected $fillable = ['name'];

    public function users(){
        return $this->belongsToMany(User::class)
        ->withPivot('role')->withTimestamps();
    }
    public function tasks(){
        return $this->hasMany(Task::class);
    }
} 