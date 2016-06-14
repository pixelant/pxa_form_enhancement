<?php
if (!defined('TYPO3_MODE')) {
  die ('Access denied.');
}

/*$initXlasses = function() {
    $classToXclass = [
        'TYPO3\CMS\Form\Domain\Factory\TypoScriptFactory' => [
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\Domain\Factory\TypoScriptFactory'
        ],
        'TYPO3\CMS\Form\View\Form\Element\ContainerElementView' => [
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\View\Element\ContainerElementView'
        ],
        'TYPO3\CMS\Form\View\Form\FormView' => [
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\View\FormView'
        ],
        'TYPO3\CMS\Form\View\Form\Element\FieldsetElementView' => [
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Form\View\Element\FieldsetElementView'
        ],
        'TYPO3\CMS\Form\Utility\FormUtility' => [
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Utility\FormUtility'
        ],
        'TYPO3\CMS\Form\Utility\ValidatorUtility' => [
            'className' => 'Pixelant\PxaFormEnhancement\Xclass\Utility\ValidatorUtility'
        ],
    ];

    foreach($classToXclass as $class => $xCLass) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$class] = $xCLass;
    }
};

$initXlasses();
unset($initXlasses);*/