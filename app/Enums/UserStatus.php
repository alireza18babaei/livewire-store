<?php

namespace App\Enums;

enum UserStatus: string
{
//UserStatus Enum Example
case Active = 'active';
case Banned = 'banned';
case Verified = 'verified';
case Unverified = 'unverified';

}

