<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    // Scheduler clean up of saved forms
    $garbageTask = \TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class;
    $table = 'tx_pxaformenhancement_domain_model_form';
    if (
        isset($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table]) &&
        !is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table])
    ) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table] = [
            'dateField' => 'crdate',
            'expirePeriod' => 30,
        ];
    }
});
