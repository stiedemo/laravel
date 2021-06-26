<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Authencation extends Authenticatable implements JWTSubject
{
    /**
     * getJWTIdentifier
     *
     * @return getKey
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * getJWTCustomClaims
     *
     * @return Array()
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
