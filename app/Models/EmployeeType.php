<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeType extends Model
{
    use HasFactory;

    protected $table = 'employee_type';

    public $timestamps = false;

    protected $fillable = [
        'type_name',
        'is_active',
        'created_at',
        'updated_at'
    ];
}
