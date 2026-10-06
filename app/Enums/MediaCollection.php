<?php

namespace App\Enums;

enum MediaCollection: string
{
    case IMAGE = 'image';
    case AVATAR = 'avatar';
    case LOGO = 'logo';
    case BANNER = 'banner';
    case GALLERY = 'gallery';
    case FAVICON = 'favicon';

}

