<?php

namespace Gtd\VueEditor\Factories;

use Bx\Model\Services\FileService;
use Gtd\VueEditor\Interfaces\ComponentSectionServiceInterface;
use Gtd\VueEditor\Interfaces\ComponentServiceFactoryInterface;
use Gtd\VueEditor\Interfaces\ComponentServiceInterface;
use Gtd\VueEditor\Services\ComponentSectionService;
use Gtd\VueEditor\Services\ComponentService;
use Gtd\VueEditor\Services\AllComponentSectionService;

class ComponentSectionServiceFactory implements ComponentServiceFactoryInterface
{
    private ComponentService $componentService;

    public function __construct()
    {
        $fileService = new FileService;
        $this->componentService = new ComponentService($fileService);
    }

    public function getSectionService(string $context): ComponentSectionServiceInterface
    {
        switch ($context) {
            case '*':
                return new AllComponentSectionService($this->componentService);
            default:
                return new ComponentSectionService($this->componentService);
        }
    }

    public function getComponentService(): ComponentServiceInterface
    {
        return $this->componentService;
    }
}
