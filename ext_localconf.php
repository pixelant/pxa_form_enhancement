<?php
defined('TYPO3_MODE') or die();

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:pxa_form_enhancement/Configuration/TypoScript/PageTS/FormWizard.ts">');

if (TYPO3_MODE === 'BE') {
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['formEngine']['nodeRegistry'][1477649676] = [
        'nodeName' => 'formwizard',
        'priority' => 50,
        'class'    => \Pixelant\PxaFormEnhancement\View\Wizard\Element\FormWizardElement::class
    ];
}