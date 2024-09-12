<?php

namespace Gtd\VueEditor;

use Gtd\VueEditor\Interfaces\DisplayRuleInterface;

class DisplayRule implements DisplayRuleInterface
{
    private mixed $value;
    private string $label;
    private string $group;

    public function jsonSerialize()
    {
        return [
            'label' => $this->label,
            'value' => $this->value,
            'group' => $this->group
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

    public function setGroup(string $group): self
    {
        $this->group = $group;
        return $this;
    }
}
