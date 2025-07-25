<?php

namespace App\Constants;

class UserRoles
{
    public const ADMIN = 'admin';
    public const USER = 'user';
    public const GUEST = 'guest';
    public const PREMIUM_USER = 'premium_user';

    public const ALL = [
           self::ADMIN,
           self::USER,
           self::GUEST,
           self::PREMIUM_USER,
       ];
}
