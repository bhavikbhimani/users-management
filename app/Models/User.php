<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Traits\FileUploadTrait;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use FileUploadTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'profile_photo_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'is_send_friend_request'
    ];

    protected $guarded = ['id'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

     public function getJWTCustomClaims()
    {
        return [];
    }

    public function getIsSendFriendRequestAttribute()
    {
        $isRequestSend = FriendRequest::where('sender_id', auth()->id())
        ->where('recipient_id', $this->id)
        ->where('status','pending')
        ->first();

        $isRequestAccepted = FriendRequest::where('sender_id', auth()->id())
        ->where('recipient_id', $this->id)
        ->where('status','accepted')
        ->first();

        if($isRequestSend){
            return "pending";
        }elseif($isRequestAccepted){
            return "accepted";
        }else{
            return "not_send";
        }
    }

    public function setProfilePhotoPathAttribute($value)
    {
        if ($value) {
            $this->saveFile($value, 'profile_photo_path', "profile_photo_path/" . date('Y/m')); 
        }else{
            $this->attributes['profile_photo_path'] = NULL;
        }
    }

    public function getProfilePhotoPathAttribute()
    {
        if (!empty($this->attributes['profile_photo_path'])) {
            return $this->getFileUrl($this->attributes['profile_photo_path']);
        }
    }
}
