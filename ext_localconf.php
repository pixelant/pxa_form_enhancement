<?php
if (!defined('TYPO3_MODE')) {
  die ('Access denied.');
}

$initXlasses = function() {
    $classToXclass = array(
        'TYPO3\CMS\Form\Domain\Factory\TypoScriptFactory' => array(
            'className' => 'Pixelant\\PxaT3formRecaptcha\\Xclass\\Form\\Domain\\Factory\\TypoScriptFactory'
        ),
        'TYPO3\CMS\Form\View\Form\Element\ContainerElementView' => array(
            'className' => 'Pixelant\PxaT3formRecaptcha\Xclass\Form\View\Element\ContainerElementView'
        ),
        'TYPO3\CMS\Form\View\Form\FormView' => array(
            'className' => 'Pixelant\PxaT3formRecaptcha\Xclass\Form\View\FormView'
        ),
        'TYPO3\CMS\Form\View\Form\Element\FieldsetElementView' => array(
            'className' => 'Pixelant\PxaT3formRecaptcha\Xclass\Form\View\Element\FieldsetElementView'
        ),
        'TYPO3\CMS\Form\Utility\FormUtility' => array(
            'className' => 'Pixelant\PxaT3formRecaptcha\Xclass\Utility\FormUtility'
        ),
        'TYPO3\CMS\Form\Utility\ValidatorUtility' => array(
            'className' => 'Pixelant\PxaT3formRecaptcha\Xclass\Utility\ValidatorUtility'
        ),
    );

    foreach($classToXclass as $class => $xCLass) {
        $GLOBALS['TYPO3_CONF_VARS']['SYS']['Objects'][$class] = $xCLass;
    }
};

$initXlasses();
unset($initXlasses);