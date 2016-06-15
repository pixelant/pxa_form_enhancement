<?php
if (!defined('TYPO3_MODE')) {
  die ('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig('<INCLUDE_TYPOSCRIPT: source="FILE:EXT:pxa_form_enhancement/Configuration/TypoScript/PageTS/FormWizard.ts">');

$initXlasses = function() {
    $classToXclass = array(
        'TYPO3\CMS\Form\Domain\Factory\TypoScriptFactory' => array(
            'className' => 'Pixelant\\PxaFormEnhancement\\Xclass\\Form\\Domain\\Factory\\TypoScriptFactory'
        ),
        'TYPO3\CMS\Form\View\Form\FormView' => array(
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\View\FormView'
        ),
        'TYPO3\CMS\Form\View\Form\Element\FieldsetElementView' => array(
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\View\Element\FieldsetElementView'
        ),
        'TYPO3\CMS\Form\Utility\FormUtility' => array(
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Utility\FormUtility'
        ),
        'TYPO3\CMS\Form\Domain\Factory\JsonToTypoScript' => array(
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\Domain\Factory\JsonToTypoScript'
        ),
        'TYPO3\CMS\Form\Utility\TypoScriptToJsonConverter' => array(
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Utility\TypoScriptToJsonConverter'
        )
    );

    foreach($classToXclass as $class => $xCLass) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$class] = $xCLass;
    }
};

$initXlasses();
unset($initXlasses);