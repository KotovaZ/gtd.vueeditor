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

class ComponentSectionService extends BaseLinkedModelService
{
    /**
     * @var int
     */
    private $iblockId;

    /**
     * @var DataManager
     */
    private $entity;

    public function __construct(private ModelServiceInterface $componentService)
    {
    }

    private function getIblockId(): int
    {
        if (!empty($this->iblockId)) {
            return (int)$this->iblockId;
        }

        Loader::includeModule('iblock');
        $iblockData = IblockTable::getRow([
            'filter' => [
                '=IBLOCK_TYPE_ID' => 'directory',
                '=CODE' => 'component',
            ],
            'select' => [
                'ID'
            ],
        ]);

        return $this->iblockId = (int)$iblockData['ID'];
    }


    /**
     * @return DataManager
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    private function getEntityObjectMethod()
    {
        if ($this->entity instanceof DataManager) {
            return $this->entity;
        }

        Loader::includeModule('iblock');
        $iblockId = $this->getIblockId();
        return $this->entity = Section::compileEntityByIblock($iblockId);
    }


    protected function getLinkedFields(): array
    {
        $filter = [
            '=ACTIVE' => 'Y'
        ];

        if ($this->issetPropertySite() === true) {
            /** @var Site $site */
            $site = Application::getInstance()->getContext()->getSite();
            if ($site->getId() !== null) {
                $filter[] = [
                    'LOGIC' => 'OR',
                    ['=SITE.VALUE' => $site->getId()],
                    ['=SITE.VALUE' => false]
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

    /**
     * @return bool
     * @throws DINotFoundException
     */
    private function issetPropertySite(): bool
    {
        /** @var IblockPropertyService $propertyService */
        $propertyService = IoC::resolve('IblockPropertyService');
        $propertySite = $propertyService->query()->setFilter([
            '=IBLOCK_ID' => $this->getIblockId(),
            '=CODE' => [
                'SITE'
            ]
        ])->getList()?->first();

        return !($propertySite === null);
    }


    /**
     * @param array $params
     * @param UserContextInterface|null $userContext
     * @return ComponentModel[]|ModelCollection
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    protected function getInternalList(array $params, ?UserContextInterface $userContext = null): ModelCollection
    {
        $params['select'] = $params['select'] ?? [
            "ID",
            "NAME",
            "ACTIVE",
            "GLOBAL_ACTIVE",
            "IBLOCK_ID",
            "MODIFIED_BY",
            "CREATED_BY",
            "DATE_CREATE",
            "SORT",
            "PICTURE",
            "DETAIL_PICTURE",
            "SOCNET_GROUP_ID",
            "DESCRIPTION",
            "DESCRIPTION_TYPE",
            "SEARCHABLE_CONTENT",
            "CODE",
            "XML_ID",
            "TMP_ID",
            "IBLOCK_SECTION_ID",
            "LEFT_MARGIN",
            "RIGHT_MARGIN",
            "DEPTH_LEVEL",
            "TIMESTAMP_X"
        ];
        $list = $this->getEntityObjectMethod()::getList($params);

        return new ModelCollection($list, ComponentSectionModel::class);
    }


    /**
     * @param int $id
     * @param UserContextInterface|null $userContext
     * @return ComponentSectionModel|AbsOptimizedModel|null
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getById(int $id, ?UserContextInterface $userContext = null): ?AbsOptimizedModel
    {
        $params = [
            'filter' => [
                '=id' => $id,
            ],
        ];
        $collection = $this->getList($params, $userContext);

        return $collection->first();
    }


    /**
     * @param array $params
     * @param UserContextInterface|null $userContext
     * @return int
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     */
    public function getCount(array $params, ?UserContextInterface $userContext = null): int
    {
        $params['filter']['=IBLOCK_ID'] = $this->getIblockId();
        $params['count_total'] = true;
        return $this->getEntityObjectMethod()::getList($params)->getCount();
    }


    /**
     * @param int $id
     * @param UserContextInterface|null $userContext
     * @return Result
     * @throws ArgumentException
     * @throws ObjectPropertyException
     * @throws SystemException
     * @throws Exception
     */
    public function delete(int $id, ?UserContextInterface $userContext = null): Result
    {
        $item = $this->getById($id, $userContext);
        if (!($item instanceof ComponentSectionModel)) {
            return (new Result)->addError(new Error('Не найдена запись для удаления'));
        }

        return $this->getEntityObjectMethod()::delete($id);
    }


    /**
     * @param ComponentSectionModel $model
     * @param UserContextInterface|null $userContext
     * @return Result
     * @throws Exception
     */
    public function save(AbsOptimizedModel $model, ?UserContextInterface $userContext = null): Result
    {
        $result = new Result();
        $dataInfo = [
            'NAME' => [
                'value' => $model->getName(),
                'isFill' => $model->hasValueKey('NAME'),
            ],
            'ACTIVE' => [
                'value' => $model->getActive(),
                'isFill' => $model->hasValueKey('ACTIVE'),
            ],
            'SORT' => [
                'value' => $model->getSort(),
                'isFill' => $model->hasValueKey('SORT'),
            ],
            'PICTURE' => [
                'value' => $model->getPicture(),
                'isFill' => $model->hasValueKey('PICTURE'),
            ],
            'DETAIL_PICTURE' => [
                'value' => $model->getDetailPicture(),
                'isFill' => $model->hasValueKey('DETAIL_PICTURE'),
            ],
            'SOCNET_GROUP_ID' => [
                'value' => $model->getSocnetGroupId(),
                'isFill' => $model->hasValueKey('SOCNET_GROUP_ID'),
            ],
            'DESCRIPTION' => [
                'value' => $model->getDescription(),
                'isFill' => $model->hasValueKey('DESCRIPTION'),
            ],
            'DESCRIPTION_TYPE' => [
                'value' => $model->getDescriptionType(),
                'isFill' => $model->hasValueKey('DESCRIPTION_TYPE'),
            ],
            'CODE' => [
                'value' => $model->getCode(),
                'isFill' => $model->hasValueKey('CODE'),
            ],
            'XML_ID' => [
                'value' => $model->getXmlId(),
                'isFill' => $model->hasValueKey('XML_ID'),
            ],
            'IBLOCK_SECTION_ID' => [
                'value' => $model->getIblockSectionId(),
                'isFill' => $model->hasValueKey('IBLOCK_SECTION_ID'),
            ],
            'LEFT_MARGIN' => [
                'value' => $model->getLeftMargin(),
                'isFill' => $model->hasValueKey('LEFT_MARGIN'),
            ],
            'RIGHT_MARGIN' => [
                'value' => $model->getRightMargin(),
                'isFill' => $model->hasValueKey('RIGHT_MARGIN'),
            ],
            'DEPTH_LEVEL' => [
                'value' => $model->getDepthLevel(),
                'isFill' => $model->hasValueKey('DEPTH_LEVEL'),
            ],
        ];

        $data = [
            'IBLOCK_ID' => $this->getIblockId(),
        ];

        foreach ($dataInfo as $name => $info) {
            if ((bool)$info['isFill']) {
                $data[$name] = $info['value'];
            }
        }

        $oSection = new CIBlockSection();
        if ($model->getId() > 0) {
            $isSuccess = (bool)$oSection->Update($model->getId(), $data);
            if (!$isSuccess) {
                return $result->addError(new Error($oSection->LAST_ERROR));
            }
            return $result;
        }

        $id = (int)$oSection->Add($data);
        if ($id > 0) {
            $model->setId($id);
            return $result;
        }

        return $result->addError(new Error($oSection->LAST_ERROR));
    }


    /**
     * @return array
     */
    public static function getSortFields(): array
    {
        return [
            "id" => "ID",
            "name" => "NAME",
            "active" => "ACTIVE",
            "global_active" => "GLOBAL_ACTIVE",
            "iblock_id" => "IBLOCK_ID",
            "modified_by" => "MODIFIED_BY",
            "created_by" => "CREATED_BY",
            "date_create" => "DATE_CREATE",
            "sort" => "SORT",
            "picture" => "PICTURE",
            "detail_picture" => "DETAIL_PICTURE",
            "socnet_group_id" => "SOCNET_GROUP_ID",
            "description" => "DESCRIPTION",
            "description_type" => "DESCRIPTION_TYPE",
            "searchable_content" => "SEARCHABLE_CONTENT",
            "code" => "CODE",
            "xml_id" => "XML_ID",
            "tmp_id" => "TMP_ID",
            "iblock_section_id" => "IBLOCK_SECTION_ID",
            "left_margin" => "LEFT_MARGIN",
            "right_margin" => "RIGHT_MARGIN",
            "depth_level" => "DEPTH_LEVEL",
            "timestamp_x" => "TIMESTAMP_X",
        ];
    }


    /**
     * @return array
     */
    public static function getFilterFields(): array
    {
        return [
            "id" => "ID",
            "name" => "NAME",
            "active" => "ACTIVE",
            "global_active" => "GLOBAL_ACTIVE",
            "iblock_id" => "IBLOCK_ID",
            "modified_by" => "MODIFIED_BY",
            "created_by" => "CREATED_BY",
            "date_create" => "DATE_CREATE",
            "sort" => "SORT",
            "picture" => "PICTURE",
            "detail_picture" => "DETAIL_PICTURE",
            "socnet_group_id" => "SOCNET_GROUP_ID",
            "description" => "DESCRIPTION",
            "description_type" => "DESCRIPTION_TYPE",
            "searchable_content" => "SEARCHABLE_CONTENT",
            "code" => "CODE",
            "xml_id" => "XML_ID",
            "tmp_id" => "TMP_ID",
            "iblock_section_id" => "IBLOCK_SECTION_ID",
            "left_margin" => "LEFT_MARGIN",
            "right_margin" => "RIGHT_MARGIN",
            "depth_level" => "DEPTH_LEVEL",
            "timestamp_x" => "TIMESTAMP_X",
        ];
    }
}
