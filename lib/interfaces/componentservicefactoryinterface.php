<?php

namespace Gtd\VueEditor\Interfaces;

use Bx\Model\Interfaces\ModelServiceInterface;

interface ComponentServiceFactoryInterface
{
    public function getSectionService(string $context, array $contextParams = []): ComponentSectionServiceInterface;
    public function getComponentService(): ComponentServiceInterface;
}