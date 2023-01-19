<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ESolution\DBEncryption\Traits\EncryptedAttribute;

class Profile extends Model
{
    use HasFactory, EncryptedAttribute;

    protected $table = 'profile_info';

    public $timestamps = false;

    protected $fillable = [
        'profile_no',
        'last_name',
        'first_name',
        'middle_name',
        'birth_date',
        'gender',
        'address',
        'mobile_no',
        'company_name',
        'employee_type',
        'profile_group',
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
        'last_name',
        'first_name',
        'middle_name',
        'birth_date',
        'gender',
        'address',
        'mobile_no',
        'company_name',
        'employee_type',
        'profile_group'
    ];
}
