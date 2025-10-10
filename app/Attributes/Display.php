<?php

namespace App\Attributes;

use Attribute;

#[Attribute]
class Display
{
    public function __construct(
        public string $label,
        public ?string $bgClass = null,
        public bool $isDefault = false,
        public bool $asBoolean = false,
    ) {}
}
