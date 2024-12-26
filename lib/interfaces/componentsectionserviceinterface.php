<?php

namespace Gtd\VueEditor\Interfaces;

use Bx\Model\Interfaces\ModelServiceInterface;

interface ComponentSectionServiceInterface extends ModelServiceInterface
{
    function getLinkedFields(): array;
}