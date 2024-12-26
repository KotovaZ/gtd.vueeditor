<?php

namespace Gtd\VueEditor\Interfaces;

use Bx\Model\Interfaces\ModelServiceInterface;

interface ComponentServiceFactoryInterface
{
    public function getSectionService(string $context): ComponentSectionServiceInterface;
    public function getComponentService(): ComponentServiceInterface;
}