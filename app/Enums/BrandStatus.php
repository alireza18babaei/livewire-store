<?php

namespace App\Enums;

use function __;

enum BrandStatus : string
{
    case Active = 'active';

    case Inactive = 'inactive';

    case Banned = 'banned';

}
