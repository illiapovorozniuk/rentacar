<?php

namespace App\Enums;

enum Route: string
{
    case DEFAULT = '/';
    case BRANDS = '/brands';
    case BODIES = '/bodies';
    case TYPES = '/types';
    case CAR = '/car';

}
