<?php
namespace App\Enum;
use App\Traits\RolesPermissions;

enum Role: string
{
    use RolesPermissions;
    case ADMIN = 'admin';
    case CUSTOMER = 'customer';
}
