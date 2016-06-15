<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 15.06.16
 * Time: 14:07
 */

namespace Pixelant\PxaFormEnhancement\Xclass\Utility;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Typoscript to JSON converter
 *
 * Takes the incoming Typoscript and converts it to Json
 *
 * @author Patrick Broens <patrick@patrickbroens.nl>
 */
class TypoScriptToJsonConverter extends \TYPO3\CMS\Form\Utility\TypoScriptToJsonConverter {

    /**
     * Set the element type of the object
     *
     * Checks if the typoscript object is part of the FORM or has a predefined
     * class for name or header object
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Json\AbstractJsonElement $parentElement The parent object
     * @param string $class A predefined class
     * @param array $arguments Configuration array
     * @return void
     */
    private function setElementType(\TYPO3\CMS\Form\Domain\Model\Json\AbstractJsonElement $parentElement, $class, array $arguments) {
        if (in_array($class, FormUtility::getInstance()->getFormObjects())) {
            if (strstr($arguments['class'], 'predefined-name')) {
                $class = 'NAME';
            }
            $this->addElement($parentElement, $class, $arguments);
        }
    }

    /**
     * Rendering of a "numerical array" of Form objects from TypoScript
     * Creates new object for each element found
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Json\AbstractJsonElement $parentElement Parent model object
     * @param array $arguments Configuration array
     * @return void
     */
    protected function getChildElementsByIntegerKey(\TYPO3\CMS\Form\Domain\Model\Json\AbstractJsonElement $parentElement, array $typoscript) {
        if (is_array($typoscript)) {
            $keys = \TYPO3\CMS\Core\TypoScript\TemplateService::sortedKeyList($typoscript);
            foreach ($keys as $key) {
                $class = $typoscript[$key];
                if ((int)$key && strpos($key, '.') === FALSE) {
                    if (isset($typoscript[$key . '.'])) {
                        $elementArguments = $typoscript[$key . '.'];
                    } else {
                        $elementArguments = array();
                    }
                    $this->setElementType($parentElement, $class, $elementArguments);
                }
            }
        }
    }
}