<?php

namespace App\Enums;

use function __;

enum CategoryStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
}
