<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 15.06.16
 * Time: 13:39
 */

namespace Pixelant\PxaFormEnhancement\Xclass\Form\Domain\Factory;


class JsonToTypoScript extends \TYPO3\CMS\Form\Domain\Factory\JsonToTypoScript {

    /**
     * Converts the JSON array for each element to a TypoScript array
     * and adds this Typoscript array to the parent
     *
     * @param array $elements The JSON array
     * @param array $parent The parent element
     * @param boolean $childrenWithParentName Indicates if the children use the parent name
     * @return void
     */
    protected function convertToTyposcriptArray(array $elements, array &$parent, $childrenWithParentName = FALSE) {
        if (is_array($elements)) {
            $elementCounter = 10;
            foreach ($elements as $element) {
                if ($element['xtype']) {
                    $this->elementId++;
                    switch ($element['xtype']) {
                        case 'typo3-form-wizard-elements-basic-button':

                        case 'typo3-form-wizard-elements-basic-checkbox':

                        case 'typo3-form-wizard-elements-basic-fileupload':

                        case 'typo3-form-wizard-elements-basic-hidden':

                        case 'typo3-form-wizard-elements-basic-password':

                        case 'typo3-form-wizard-elements-basic-radio':

                        case 'typo3-form-wizard-elements-basic-reset':

                        case 'typo3-form-wizard-elements-basic-select':

                        case 'typo3-form-wizard-elements-basic-submit':

                        case 'typo3-form-wizard-elements-basic-textarea':

                        case 'typo3-form-wizard-elements-basic-textline':

                        case 'typo3-form-wizard-elements-predefined-email':

                        case 'typo3-form-wizard-elements-content-header':

                        case 'typo3-form-wizard-elements-content-textblock':

                        case 'typo3-form-wizard-elements-basic-recaptcha':
                            $this->getDefaultElementSetup($element, $parent, $elementCounter, $childrenWithParentName);
                            break;
                        case 'typo3-form-wizard-elements-basic-fieldset':

                        case 'typo3-form-wizard-elements-predefined-name':
                            $this->getDefaultElementSetup($element, $parent, $elementCounter);
                            $this->getContainer($element, $parent, $elementCounter);
                            break;
                        case 'typo3-form-wizard-elements-predefined-checkboxgroup':

                        case 'typo3-form-wizard-elements-predefined-radiogroup':
                            $this->getDefaultElementSetup($element, $parent, $elementCounter);
                            $this->getContainer($element, $parent, $elementCounter, TRUE);
                            break;
                        case 'typo3-form-wizard-elements-basic-form':
                            $this->getDefaultElementSetup($element, $parent, $elementCounter);
                            $this->getContainer($element, $parent, $elementCounter);
                            $this->getForm($element, $parent, $elementCounter);
                            break;
                        default:

                    }
                }
                $elementCounter = $elementCounter + 10;
            }
        }
    }
}