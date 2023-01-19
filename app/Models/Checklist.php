<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Checklist extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $table = 'checklist';

    public $timestamps = false;

    protected $fillable = [
        'checklist',
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
        'checklist'
    ];
}
