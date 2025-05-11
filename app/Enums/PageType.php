<?php

namespace App\Enums;

enum PageType: string
{
    case PAGE = 'page';
    case DEFAULT = 'default';
    case BRANDS = 'brands';
    case BODIES = 'bodies';
    case TYPES = 'types';
    case BRAND = 'brand';
    case BODY = 'body';
    case TYPE = 'type';
}
