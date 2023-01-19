<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class UserGroup extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $table = 'user_group';

    public $timestamps = false;

    protected $fillable = [
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
        'group_name'
    ];
}
