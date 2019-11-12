<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:pxa_form_enhancement/Configuration/TypoScript/PageTS/FormWizard.ts">');

call_user_func(function () {
    // Scheduler clean up of saved forms
    $garbageTask = \TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class;
    $table = 'tx_pxaformenhancement_domain_model_form';
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table])) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table] = [
            'dateField' => 'crdate',
            'expirePeriod' => 30,
        ];
    }
});
