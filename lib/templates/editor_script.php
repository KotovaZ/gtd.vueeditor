<script>
    (() => {
        const editor = new document.vueeditor([], '<?= $this->getInputName() ?>', [], '<?= $this->getAppId() ?>')
            .setJsonValue(<?= $this->getValue() ?>)
            .setJsonAllowBlocks(<?= CUtil::PhpToJSObject($this->getAllowBlocks()) ?>);

        <?php if ($this->getShowPatterns()) : ?>
            editor.setShowPatterns(true)
                .setPatterns(<?= CUtil::PhpToJSObject($this->getPatterns()) ?>);
        <?php endif; ?>

        editor.initEditor();
    })()
</script>