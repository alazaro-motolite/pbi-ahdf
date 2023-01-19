<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class EntryPoint extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $table = 'entry_point';

    public $timestamps = false;

    protected $fillable = [
        'entry_point',
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
        'entry_point',
    ];
}
