<?php

namespace App\Enum;

enum UserSettings: int
{
    case REF_CODE = 1;

    public function label(): string
    {
        return match ($this) {
            self::REF_CODE => 'Referral Code',
        };
    }
}
