<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';

    public $timestamps = false;

    protected $fillable = [
        'reference_no',
        'profile_id',
        'is_expose',
        'answer',
        'entry_point_id',
        'last_visit',
        'confirmation_date'
    ];
}
