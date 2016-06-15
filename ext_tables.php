<?php
defined('TYPO3_MODE') or die();

$init = function ($_EXTKEY) {
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Pxa Form Enhancement');

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pxaformenhancement_domain_model_form', 'EXT:pxa_form_enhancement/Resources/Private/Language/locallang_csh_tx_pxaformenhancement_domain_model_form.xlf');
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pxaformenhancement_domain_model_form');

    $classToXClass = [
        // xclass form Json to Typoscript converter, there is no any hook to add new form element
        'TYPO3\CMS\Form\Domain\Factory\JsonToTypoScript' => 'Pixelant\PxaFormEnhancement\Xclass\Factory\JsonToTypoScript',
        // same for Typoscript to Json converter
        'TYPO3\CMS\Form\Utility\TypoScriptToJsonConverter' => 'Pixelant\PxaFormEnhancement\Xclass\Utility\TypoScriptToJson'
    ];

    foreach ($classToXClass as $class => $xClass) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$class] = [
            'className' => $xClass
        ];
    }

    # register hook
    $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['form']['hooks']['renderWizard'][$_EXTKEY] = 'Pixelant\PxaFormEnhancement\Hooks\WizardViewHook->renderHook';
};

$init($_EXTKEY);
unset($init);