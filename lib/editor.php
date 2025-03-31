<?php

namespace Gtd\VueEditor;

use Bitrix\Main\Loader;
use Bitrix\Main\Page\Asset;
use Bx\Model\ModelCollection;
use Gtd\VueEditor\Factories\ComponentSectionServiceFactory;
use Gtd\VueEditor\Interfaces\ComponentServiceFactoryInterface;
use Gtd\VueEditor\Models\ComponentModel;
use Gtd\VueEditor\Models\ComponentSectionModel;

class Editor
{

    const ASSET_SUB_DIR = '/local/vueeditor_assets';

    private $moduleDir;

    private $assetDir;

    private $app_id;

    private $property_id;

    private $input_name;

    private $value = '[]';

    private $allowBlocks = [];
    private $showPatterns = false;
    private $showDisplayRules = true;
    private $displayRules = [];
    private $context = 'default';

    /**
     * @var string
     */
    private $input;

    public function __construct(
        $baseDir = "",
        private ?ComponentServiceFactoryInterface $componentServiceFactory = null
    ) {
        $this->app_id = $this->generateAppId();
        $real_base_dir = dirname(__FILE__, 5);
        if ($baseDir === "") {
            //TODO : находить путь от document_root динамично
            $this->moduleDir = str_replace($real_base_dir, "",  realpath(__DIR__ . '/../../../..'));
        }
        $this->assetDir = $this->moduleDir . self::ASSET_SUB_DIR;

        if (empty($this->componentService)) {
            $this->componentServiceFactory = new ComponentSectionServiceFactory;
        }
    }

    public function setContext(string $context)
    {
        $this->context = $context;
    }

    public function initEditor()
    {
        $event = new \Bitrix\Main\Event(
            'gtd.vueeditor',
            'onBeforeInit',
            [
                'editor' => $this
            ]
        );
        $event->send();

        $this->loadJsFiles();
        $this->renderHtml();
    }

    private function renderHtml()
    {
        echo "<div id='$this->app_id'></div>";
        $this->renderTemplate('editor_script');
    }

    private function renderTemplate($name)
    {
        $path = __DIR__ . '/templates/' . $name . '.php';
        if (is_file($path)) {
            include $path;
        }
    }

    public function loadJsFiles()
    {
        $asset = Asset::getInstance();
        $asset->addString('<link rel="stylesheet" href="/local/modules/gtd.vueeditor/app/src/index.css">');
        foreach ($this->getJsFile() as $jsFileName) {
            $asset->addJs($this->assetDir . '/' . $jsFileName);
        }
    }

    /**
     * @return array|false
     */
    private function getJsFile()
    {
        $assetFiles = scandir($this->getAssetDir());
        return array_filter($assetFiles, function ($arr1) {
            return stripos($arr1, '.js');
        });
    }

    /**
     * @return string
     */
    public function getAssetDir($from_root = true)
    {
        if ($from_root) {
            return $_SERVER['DOCUMENT_ROOT'] . $this->assetDir;
        }
        return $this->assetDir;
    }

    private function generateAppId()
    {
        return "gtd_vue_editor_" . rand(0, 999);
    }


    /**
     * @param string $value
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return json_encode($this->value);
    }

    /**
     * @return string
     */
    public function getAppId(): string
    {
        return $this->app_id;
    }

    /**
     * @param array $allowBlocks
     */
    public function setAllowBlocks(array $allowBlocks): Editor
    {
        $this->allowBlocks = $allowBlocks;
        return $this;
    }

    /**
     * @return string
     */
    public function getAllowBlocks(): string
    {
        return json_encode($this->allowBlocks);
    }

    /**
     * @return array
     */
    public function getPatterns($codes = []): array
    {
        Loader::includeModule('bx.model');

        if (empty($codes)) {
            $componentSectionService = $this->componentServiceFactory->getSectionService($this->context);
            return $componentSectionService
                ->getList([])
                ->jsonSerialize();
        }

        $section = new ComponentSectionModel([]);
        $section->setId(0)
            ->setActive('Y')
            ->setCode('root')
            ->setSort(100);

        $components = $this->componentServiceFactory->getComponentService()
            ->getList(['filter' => ['CODE' => $codes]])
            ->map(function (ComponentModel $section) {
                $section->setSectionId(0);
                return $section;
            });

        $section->setComponents(new ModelCollection($components, ComponentModel::class));
        return [$section->jsonSerialize()];
    }

    /**
     * @param mixed $input_name
     */
    public function setInputName($input_name): Editor
    {
        $this->input_name = $input_name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInputName()
    {
        return $this->input_name;
    }

    /**
     * @param mixed $property_id
     */
    public function setPropertyId($property_id)
    {
        $this->property_id = $property_id;
    }

    /**
     * @return mixed
     */
    public function getPropertyId()
    {
        return $this->property_id;
    }

    /**
     * @param bool $value
     */
    public function setShowPatterns($value)
    {
        $this->showPatterns = $value;
    }

    /**
     * @return boolean
     */
    public function getShowPatterns()
    {
        return (bool)$this->showPatterns;
    }

    /**
     * @param bool $value
     */
    public function setShowDisplayRules($value)
    {
        $this->showDisplayRules = $value;
    }

    /**
     * @return boolean
     */
    public function getShowDisplayRules()
    {
        return (bool)$this->showDisplayRules;
    }

    /**
     * @return DisplayRule[]
     */
    public function getDisplayRules(): array
    {
        return $this->displayRules;
    }

    /**
     * @param DisplayRule[] $displayRules
     * @return self
     */
    public function setDisplayRules(array $displayRules): self
    {
        $this->displayRules = $displayRules;
        return $this;
    }
}
