<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $appends = ['created_at_human'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getCreatedAtHumanAttribute(){
        return $this->created_at->diffForHumans();
    }
}
