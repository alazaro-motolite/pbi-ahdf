<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class User extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $table = 'users';

    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'group_id',
        'group_name',
        'created_at',
        'updated_at'
    ];

    
    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'name',
        'email',
        'group_name'
    ];
}
