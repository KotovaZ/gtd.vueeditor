<?php

namespace Gtd\VueEditor\Services;

use Bitrix\Iblock\Elements\ElementComponentTable;
use Bitrix\Main\ArgumentException;
use Bitrix\Main\Error;
use Bitrix\Main\ORM\Objectify\State;
use Bitrix\Main\ObjectPropertyException;
use Bitrix\Main\Result;
use Bitrix\Main\SystemException;
use Bx\Model\AbsOptimizedModel;
use Bx\Model\BaseLinkedModelService;
use Bx\Model\FetcherModel;
use Bx\Model\Interfaces\ModelServiceInterface;
use Bx\Model\Interfaces\Models\IblockServiceInterface;
use Bx\Model\Interfaces\UserContextInterface;
use Bx\Model\ModelCollection;
use Bx\Model\Traits\IblockServiceTrait;
use Gtd\VueEditor\Models\ComponentModel;
use Exception;

class ComponentService extends BaseLinkedModelService implements IblockServiceInterface
{
	use IblockServiceTrait;

	/**
	 * @var ModelServiceInterface
	 */
	public $fileService;
	private $iblockId;


	public function __construct(ModelServiceInterface $fileService)
	{
		$this->fileService = $fileService;
	}


	public function getIblockId(): int
	{
		if (!empty($this->iblockId)) {
		    return $this->iblockId;
		}

		return $this->iblockId = (int)ElementComponentTable::getEntity()->getIblock()->getId();
	}


	protected function getLinkedFields(): array
	{
		return [
		    'preview_file' => new FetcherModel(
		        $this->fileService,
		        'preview_file',
		        'PREVIEW_PICTURE',
		        'ID'
		    ),
		    'detail_file' => new FetcherModel(
		        $this->fileService,
		        'detail_file',
		        'DETAIL_PICTURE',
		        'ID'
		    ),
		];
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
			"IBLOCK_ID",
			"DATE_CREATE",
			"ACTIVE_FROM",
			"ACTIVE_TO",
			"SORT",
			"PREVIEW_PICTURE",
			"PREVIEW_TEXT",
			"DETAIL_PICTURE",
			"DETAIL_TEXT",
			"CODE",
			"TAGS",
			"IBLOCK_SECTION_ID",
			"TIMESTAMP_X",
			"CONSTRUCTOR_VALUE" => "CONSTRUCTOR.VALUE"
		];
		$list = ElementComponentTable::getList($params);

		return new ModelCollection($list, ComponentModel::class);
	}


	/**
	 * @param int $id
	 * @param UserContextInterface|null $userContext
	 * @return ComponentModel|AbsOptimizedModel|null
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
		$params['count_total'] = true;
		return ElementComponentTable::getList($params)->getCount();
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
		if (!($item instanceof ComponentModel)) {
		    return (new Result)->addError(new Error('Не найдена запись для удаления'));
		}

		return ElementComponentTable::delete($id);
	}


	/**
	 * @param ComponentModel $model
	 * @param UserContextInterface|null $userContext
	 * @return Result
	 * @throws Exception
	 */
	public function save(AbsOptimizedModel $model, ?UserContextInterface $userContext = null): Result
	{
		$element = new \Bitrix\Iblock\Elements\EO_ElementComponent();
		if ($model->getId() > 0) {
		    $element->setId($model->getId());
		    $element->sysChangeState(State::CHANGED);
		}


		if($model->hasValueKey('NAME')) {
		    $element->set('NAME', $model->getName());
		}

		if($model->hasValueKey('ACTIVE')) {
		    $element->set('ACTIVE', $model->getActive());
		}

		if($model->hasValueKey('DATE_CREATE')) {
		    $element->set('DATE_CREATE', $model->getDateCreate());
		}

		if($model->hasValueKey('ACTIVE_FROM')) {
		    $element->set('ACTIVE_FROM', $model->getActiveFrom());
		}

		if($model->hasValueKey('ACTIVE_TO')) {
		    $element->set('ACTIVE_TO', $model->getActiveTo());
		}

		if($model->hasValueKey('SORT')) {
		    $element->set('SORT', $model->getSort());
		}

		if($model->hasValueKey('PREVIEW_PICTURE')) {
		    $element->set('PREVIEW_PICTURE', $model->getPreviewPicture());
		}

		if($model->hasValueKey('PREVIEW_TEXT')) {
		    $element->set('PREVIEW_TEXT', $model->getPreviewText());
		}

		if($model->hasValueKey('DETAIL_PICTURE')) {
		    $element->set('DETAIL_PICTURE', $model->getDetailPicture());
		}

		if($model->hasValueKey('DETAIL_TEXT')) {
		    $element->set('DETAIL_TEXT', $model->getDetailText());
		}

		if($model->hasValueKey('CODE')) {
		    $element->set('CODE', $model->getCode());
		}

		if($model->hasValueKey('TAGS')) {
		    $element->set('TAGS', $model->getTags());
		}

		if($model->hasValueKey('IBLOCK_SECTION_ID')) {
		    $element->set('IBLOCK_SECTION_ID', $model->getIblockSectionId());
		}

		if($model->hasValueKey('CONSTRUCTOR_VALUE')) {
		    $element->set('CONSTRUCTOR', $model->getConstructor());
		}

		if ($model->getId() > 0) {
		    return $element->save();
		}

		$result = $element->save();
		if ($result->isSuccess()) {
		    $model->setId($result->getId());
		}

		return $result;
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
			"iblock_id" => "IBLOCK_ID",
			"date_create" => "DATE_CREATE",
			"active_from" => "ACTIVE_FROM",
			"active_to" => "ACTIVE_TO",
			"sort" => "SORT",
			"preview_picture" => "PREVIEW_PICTURE",
			"preview_text" => "PREVIEW_TEXT",
			"detail_picture" => "DETAIL_PICTURE",
			"detail_text" => "DETAIL_TEXT",
			"code" => "CODE",
			"tags" => "TAGS",
			"iblock_section_id" => "IBLOCK_SECTION_ID",
			"timestamp_x" => "TIMESTAMP_X",
			"constructor" => "CONSTRUCTOR.VALUE",
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
			"iblock_id" => "IBLOCK_ID",
			"date_create" => "DATE_CREATE",
			"active_from" => "ACTIVE_FROM",
			"active_to" => "ACTIVE_TO",
			"sort" => "SORT",
			"preview_picture" => "PREVIEW_PICTURE",
			"preview_text" => "PREVIEW_TEXT",
			"detail_picture" => "DETAIL_PICTURE",
			"detail_text" => "DETAIL_TEXT",
			"code" => "CODE",
			"tags" => "TAGS",
			"iblock_section_id" => "IBLOCK_SECTION_ID",
			"timestamp_x" => "TIMESTAMP_X",
			"constructor" => "CONSTRUCTOR.VALUE",
		];
	}
}
