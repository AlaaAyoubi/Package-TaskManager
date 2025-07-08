<?php

namespace Alaa\TaskManager\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Team;

class Task extends Model
{
    //
    protected $fillable = [
        'title',
        'description',
        'team_id',
        'user_id',
        'status',
        'priority',
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class); // assignee
    }
}
