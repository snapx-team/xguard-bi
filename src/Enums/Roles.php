<?php

namespace Xguard\BusinessIntelligence\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static Roles ADMIN()
 * @method static Roles EMPLOYEE();
 */

class Roles extends Enum
{
    private const ADMIN = 'admin';
    private const EMPLOYEE = 'employee';
}
