<?php

namespace Gtd\VueEditor;

use Gtd\VueEditor\Interfaces\DisplayRuleInterface;

class DisplayRule implements DisplayRuleInterface
{
    private mixed $value;
    private string $label;

    public function jsonSerialize()
    {
        return [
            'label' => $this->label,
            'value' => $this->value
        ];
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;
        return $this;
    }
    public function setLabel(string $value): self
    {
        $this->label = $value;
        return $this;
    }
}
