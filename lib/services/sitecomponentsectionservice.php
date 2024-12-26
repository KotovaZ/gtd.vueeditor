<?php

namespace Gtd\VueEditor\Services;

use Bitrix\Iblock\IblockTable;
use Bitrix\Iblock\Model\Section;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Error;
use Bitrix\Main\Loader;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use Bx\Model\AbsOptimizedModel;
use Bx\Model\BaseLinkedModelService;
use Bx\Model\FetcherModel;
use Bx\Model\Interfaces\ModelServiceInterface;
use Bx\Model\Interfaces\UserContextInterface;
use Bx\Model\ModelCollection;
use Bx\Model\Services\IblockPropertyService;
use CIBlockSection;
use Ctt\Ring\Dealer\Admin\Application;
use Ctt\Ring\DI\IoC;
use Ctt\Ring\Models\Site;
use Gtd\VueEditor\Models\ComponentSectionModel;
use Bx\Model\Query;
use DI\NotFoundException as DINotFoundException;
use Exception;
use Gtd\VueEditor\Interfaces\componentsectionserviceinterface;

class SiteComponentSectionService extends ComponentSectionService
{
    function getLinkedFields(): array
    {
        $filter = [
            '=ACTIVE' => 'Y'
        ];

        if ($this->issetPropertySite() === true) {
            /** @var Site $site */
            $site = Application::getInstance()->getContext()->getSite();
            if ($site->getId() !== null) {
                $filter[] = [
                ];
            }
        }

        return [
            'components' => FetcherModel::initAsMultipleValue(
                $this->componentService,
                'components',
                'ID',
                'IBLOCK_SECTION_ID',
                (new Query())->setFilter($filter)
            ),
        ];
    }
}
