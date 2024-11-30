<?php

namespace Gtd\VueEditor\Models;

use Bx\Model\AbsOptimizedModel;
use Bx\Model\Interfaces\CollectionInterface;
use Bx\Model\ModelCollection;
use Ctt\Ring\Models\Attributes\Model;

class ComponentSectionModel extends AbsOptimizedModel
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
			"code" => $this->getCode()
		];

		if ($this->hasValueKey('components')) {
			$data['components'] = $this->getComponents()->jsonSerialize();
		}

		return $data;
	}

	#[Model(field: 'components', model: ComponentModel::class, collection: true)]
	public function getComponents(): ?ModelCollection
	{
		return $this["components"];
	}


	public function setComponents(CollectionInterface $components): self
	{
		$this["components"] = $components;
		return $this;
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
	 * @return self
	 */
	public function setId(int $value): self
	{
		$this["ID"] = $value;
		return $this;
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
	 * @return self
	 */
	public function setName(string $value): self
	{
		$this["NAME"] = $value;
		return $this;
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
	 * @return self
	 */
	public function setActive(string $value): self
	{
		$this["ACTIVE"] = $value;
		return $this;
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
	 * @return self
	 */
	public function setSort(int $value): self
	{
		$this["SORT"] = $value;
		return $this;
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
	 * @return self
	 */
	public function setCode(string $value): self
	{
		$this["CODE"] = $value;
		return $this;
	}
}
