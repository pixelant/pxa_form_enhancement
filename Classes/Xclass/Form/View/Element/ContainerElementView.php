<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 10:10
 */

namespace Pixelant\PxaFormEnhancement\Xclass\Form\View\Element;


class ContainerElementView extends \TYPO3\CMS\Form\View\Form\Element\ContainerElementView {

    /**
     * Create child object from the classname of the model
     *
     * @param object $modelChild The childs model
     * @return \TYPO3\CMS\Form\View\Form\Element\AbstractElementView
     */
    public function createChildElementFromModel($modelChild) {
        $childElement = NULL;
        $class = \TYPO3\CMS\Form\Utility\FormUtility::getInstance()->getLastPartOfClassName($modelChild);

        if(strtolower($class) === 'recaptcha') {
            $className = 'Pixelant\PxaFormEnhancement\Xclass\Form\View\Element\RecaptchaElementView';
        } else {
            $className = 'TYPO3\CMS\Form\View\Form\Element\\' . ucfirst($class) . 'ElementView';
        }

        if (class_exists($className)) {
            $childElement = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($className, $modelChild);
        }
        return $childElement;
    }
}