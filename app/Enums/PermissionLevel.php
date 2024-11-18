<?php

namespace App\Enums;

enum PermissionLevel: int
{
    case USER = 1;
    case ADMIN = 2;
    case SUPER_ADMIN = 3;
}