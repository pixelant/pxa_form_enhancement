<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 13:52
 */

namespace Pixelant\PxaT3formRecaptcha\Xclass\Utility;


class ValidatorUtility extends \TYPO3\CMS\Form\Utility\ValidatorUtility {

    /**
     * Create a rule object according to class
     * and sent some arguments
     *
     * @param string $class Name of the validation rule
     * @param array $arguments Configuration of the rule
     * @return \TYPO3\CMS\Form\Validation\AbstractValidator The rule object
     */
    public function createRule($class, $arguments = array()) {
        $class = strtolower((string) $class);

        if($class === 'recaptcha') {
            $className = 'Pixelant\\PxaT3formRecaptcha\\Validation\\RecaptchaValidator';
        } else {
            $className = 'TYPO3\\CMS\\Form\\Validation\\' . ucfirst($class) . 'Validator';
        }

        $rule = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($className, $arguments);
        return $rule;
    }
}