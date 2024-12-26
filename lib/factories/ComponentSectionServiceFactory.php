<?php

namespace Gtd\VueEditor\Factories;

use Gtd\VueEditor\Interfaces\componentsectionserviceinterface;
use Gtd\VueEditor\Services\ComponentSectionService;
use Gtd\VueEditor\Services\ComponentService;
use Gtd\VueEditor\Services\SiteComponentSectionService;

class ComponentSectionServiceFactory
{
    public static function create(string $context, ComponentService $componentService): componentsectionserviceinterface
    {
        switch ($context) {
            case 'site':
                return new SiteComponentSectionService($componentService);
            default:
                return new ComponentSectionService($componentService);
        }
    }
}
