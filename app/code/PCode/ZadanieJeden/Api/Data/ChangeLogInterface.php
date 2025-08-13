<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Api\Data;

interface ChangeLogInterface
{
    public const ID = 'entity_id';
    public const PRODUCT_ID = 'product_id';
    public const OLD_VALUE = 'old_value';
    public const NEW_VALUE = 'new_value';
    public const ADMIN_USER_ID = 'admin_user_id';
    public const CHANGED_AT = 'changed_at';
}
