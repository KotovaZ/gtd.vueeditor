<?php

namespace Gtd\VueEditor\Models;

use Bitrix\Main\Type\DateTime;
use Bx\Model\AbsOptimizedModel;
use Bx\Model\Interfaces\ModelInterface;
use Ctt\Ring\Models\Attributes\Model;

class ComponentModel extends AbsOptimizedModel
{
	/**
	 * @return array
	 */
	protected function toArray(): array
	{
		$data = [
			"id" => $this->getId(),
			"name" => $this->getName(),
			"sort" => $this->getSort(),
			"code" => $this->getCode(),
			"section_id" => $this->getIblockSectionId(),
			"constructor" => $this->getConstructor(),
		];

		if ($this->hasValueKey('preview_file')) {
			$data['preview_picture'] = $this->getPreviewPicture()->jsonSerialize();
		}

		return $data;
	}


	/**
	 * @return int
	 */
	public function getId(): int
	{
		return (int)$this["ID"];
	}


	/**
	 * @param int $value
	 * @return void
	 */
	public function setId(int $value)
	{
		$this["ID"] = $value;
	}


	/**
	 * @return string
	 */
	public function getName(): string
	{
		return (string)$this["NAME"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setName(string $value)
	{
		$this["NAME"] = $value;
	}


	/**
	 * @return string
	 */
	public function getActive(): string
	{
		return (string)$this["ACTIVE"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setActive(string $value)
	{
		$this["ACTIVE"] = $value;
	}


	/**
	 * @return int
	 */
	public function getIblockId(): int
	{
		return (int)$this["IBLOCK_ID"];
	}


	/**
	 * @param int $value
	 * @return void
	 */
	public function setIblockId(int $value)
	{
		$this["IBLOCK_ID"] = $value;
	}


	/**
	 * @return ?DateTime
	 */
	public function getDateCreate(): ?DateTime
	{
		return $this["DATE_CREATE"] instanceof DateTime ? $this["DATE_CREATE"] : null;
	}


	/**
	 * @param DateTime $value
	 * @return void
	 */
	public function setDateCreate(DateTime $value)
	{
		$this["DATE_CREATE"] = $value;
	}


	/**
	 * @return ?DateTime
	 */
	public function getActiveFrom(): ?DateTime
	{
		return $this["ACTIVE_FROM"] instanceof DateTime ? $this["ACTIVE_FROM"] : null;
	}


	/**
	 * @param DateTime $value
	 * @return void
	 */
	public function setActiveFrom(DateTime $value)
	{
		$this["ACTIVE_FROM"] = $value;
	}


	/**
	 * @return ?DateTime
	 */
	public function getActiveTo(): ?DateTime
	{
		return $this["ACTIVE_TO"] instanceof DateTime ? $this["ACTIVE_TO"] : null;
	}


	/**
	 * @param DateTime $value
	 * @return void
	 */
	public function setActiveTo(DateTime $value)
	{
		$this["ACTIVE_TO"] = $value;
	}


	/**
	 * @return int
	 */
	public function getSort(): int
	{
		return (int)$this["SORT"];
	}


	/**
	 * @param int $value
	 * @return void
	 */
	public function setSort(int $value)
	{
		$this["SORT"] = $value;
	}



	#[Model(field: 'preview_file', model: File::class)]
	public function getPreviewPicture(): ?ModelInterface
	{
		return $this["preview_file"];
	}


	/**
	 * @param int $value
	 * @return void
	 */
	public function setPreviewPicture(int $value)
	{
		$this["PREVIEW_PICTURE"] = $value;
	}


	/**
	 * @return string
	 */
	public function getPreviewText(): string
	{
		return (string)$this["PREVIEW_TEXT"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setPreviewText(string $value)
	{
		$this["PREVIEW_TEXT"] = $value;
	}


	/**
	 * @return int
	 */
	public function getDetailPicture(): int
	{
		return (int)$this["DETAIL_PICTURE"];
	}


	/**
	 * @param int $value
	 * @return void
	 */
	public function setDetailPicture(int $value)
	{
		$this["DETAIL_PICTURE"] = $value;
	}


	/**
	 * @return string
	 */
	public function getDetailText(): string
	{
		return (string)$this["DETAIL_TEXT"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setDetailText(string $value)
	{
		$this["DETAIL_TEXT"] = $value;
	}


	/**
	 * @return string
	 */
	public function getCode(): string
	{
		return (string)$this["CODE"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setCode(string $value)
	{
		$this["CODE"] = $value;
	}


	/**
	 * @return string
	 */
	public function getTags(): string
	{
		return (string)$this["TAGS"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setTags(string $value)
	{
		$this["TAGS"] = $value;
	}


	/**
	 * @return string
	 */
	public function getIblockSectionId(): string
	{
		return (string)$this["IBLOCK_SECTION_ID"];
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setIblockSectionId(string $value)
	{
		$this["IBLOCK_SECTION_ID"] = $value;
	}


	/**
	 * @return ?DateTime
	 */
	public function getTimestampX(): ?DateTime
	{
		return $this["TIMESTAMP_X"] instanceof DateTime ? $this["TIMESTAMP_X"] : null;
	}


	/**
	 * @param DateTime $value
	 * @return void
	 */
	public function setTimestampX(DateTime $value)
	{
		$this["TIMESTAMP_X"] = $value;
	}


	/**
	 * @return array
	 */
	public function getConstructor(): array
	{
		return json_decode($this["CONSTRUCTOR_VALUE"], true);
	}


	/**
	 * @param string $value
	 * @return void
	 */
	public function setConstructor(string $value)
	{
		$this["CONSTRUCTOR_VALUE"] = $value;
	}
}
