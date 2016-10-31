<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 28.10.16
 * Time: 13:17
 */

namespace Pixelant\PxaFormEnhancement\View\Wizard\Element;


/**
 * Class FormWizardElement
 * @package Pixelant\PxaFormEnhancement\View\Wizard\Element
 */
class FormWizardElement extends \TYPO3\CMS\Form\View\Wizard\Element\FormWizardElement  {

    /**
     * changes for render form wizard
     *
     * @return array
     */
    public function render() {
        $this->resultArray = parent::render();

        // replace standard wizard script
        foreach ($this->resultArray['requireJsModules'] as $key => $requireJsModule) {
            $requireJsModuleName = key($requireJsModule);

            if($requireJsModuleName === 'TYPO3/CMS/Form/Wizard') {
                $this->resultArray['requireJsModules'][$key] = ['TYPO3/CMS/PxaFormEnhancement/Wizard/Wizard' => $requireJsModule[$requireJsModuleName]];
            }
        }

        $this->resultArray['additionalInlineLanguageLabelFiles'][] = 'EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf';
        $this->resultArray['stylesheetFiles'][] = 'EXT:pxa_form_enhancement/Resources/Public/Css/Wizard/basic.css';

        return $this->resultArray;
    }
}