<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "admins";
    const DEFAULT_PASSWORD = "123456";
    const ADMIN_PERMISSION = 'Admin';
    const GUEST_PERMISSION = 1;
    const HOST_PERMISSION = 2;
    const COMMENT_PERMISSION = 3;
    const HOMESTAY_PERMISSION = 4;
    const CONFIG_PERMISSION = 5;

    protected $fillable = [
        'name', 'email', 'password', 'permiss',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function handleStore($rq)
    {
        $this->name = $rq->name ?? $this->name;
        $this->password = $this->password ?? bcrypt(self::DEFAULT_PASSWORD);
        $this->email = $rq->email ?? $this->email;
        $this->permiss = serialize($rq->permiss) ?? $this->permiss;
        return $this->save();
    }

    public function handleResetPassword()
    {
        $this->password = bcrypt('123456');
        return $this->save();
    }

    public function isPermissed($key)
    {
        if( in_array( $key, is_array( @unserialize($this->permiss) ) ? unserialize($this->permiss) : []  ) )
        {
            return true;
        }
        return false;
    }

    public function isSuperAccount()
    {
        if( $this->permiss === self::ADMIN_PERMISSION )
        {
            return true;
        }
        return false;
    }
}