<?php

namespace Gtd\VueEditor\Interfaces;

use JsonSerializable;

interface DisplayRuleInterface extends JsonSerializable
{
    public function setValue(mixed $value): self;
    public function setLabel(string $value): self;
}
