<script>
    (() => {
        const editor = new document.vueeditor([], '<?= $this->getInputName() ?>', [], '<?= $this->getAppId() ?>')
            .setJsonValue(<?= $this->getValue() ?>)
            .setJsonAllowBlocks(<?= CUtil::PhpToJSObject($this->getAllowBlocks()) ?>);

        <?php

        use Gtd\VueEditor\Interfaces\DisplayRuleInterface;

        $displayRules = array_map(
            fn (JsonSerializable $rule) => $rule->jsonSerialize(),
            $this->getDisplayRules()
        );
        ?>

        <?php
        if ($this->getShowPatterns()) : ?>
            editor.setShowPatterns(true)
                .setPatterns(<?= CUtil::PhpToJSObject($this->getPatterns()) ?>);
        <?php endif; ?>

        <?php if ($this->getShowDisplayRules()) : ?>
            editor.setShowDisplayRules(true)
                .setDisplayRules(<?= CUtil::PhpToJSObject($displayRules) ?>);
        <?php endif; ?>

        editor.initEditor();
    })()
</script>