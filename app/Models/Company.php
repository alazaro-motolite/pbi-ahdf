<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Company extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $table = 'company';

    public $timestamps = false;

    protected $fillable = [
        'company',
        'is_active',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be encrypted on save.
     *
     * @var array
     */
    protected $encryptable = [
        'company'
    ];
}
