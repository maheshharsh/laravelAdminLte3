<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\admin\ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /*
     * Constants for column names.
     */
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const PASSWORD = 'password';
    const MOBILENO = 'mobileno';
    const GENDER = 'gender';
    const STATUS = 'status';
    const PROFILEIMAGE = 'profile_image';

    /* User Gender. */
    const GENDER_OPTIONS = [
        self::GENDER_MALE => 'Male',
        self::GENDER_FEMALE => 'Female',
    ];

    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /* User status for select user. */
    const USER_STATUS_OPTIONS = [
        1 => 'Active',
        2 => 'Inactive',
    ];

    const USER_STATUS_ACTIVE = 1;
    const USER_STATUS_INACTIVE = 2;

    
 /*
     * Constants for permissions's permissions.
     */
    const BROWSE_USER = 'browse_user';
    const VIEW_USER   = 'view_user';
    const CREATE_USER = 'create_user';
    const UPDATE_USER = 'update_user';
    const DELETE_USER = 'delete_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'mobileno',
        'gender',
        'status',
        'profile_image',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // public function sendPasswordResetNotification($token) {
    //     $this->notify(new ResetPasswordNotification($token));
    // }
}
