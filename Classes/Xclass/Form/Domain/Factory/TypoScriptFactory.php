<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 9:52
 */

namespace Pixelant\PxaT3formRecaptcha\Xclass\Form\Domain\Factory;


use Pixelant\PxaT3formRecaptcha\Xclass\Utility\FormUtility;

class TypoScriptFactory extends \TYPO3\CMS\Form\Domain\Factory\TypoScriptFactory {

    /**
     * Create element by loading class
     * and instantiating the object
     *
     * @param string $class Type of element
     * @param array $arguments Configuration array
     * @return \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement
     * @throws \InvalidArgumentException
     */
    public function createElement($class, array $arguments = array()) {
        $class = strtolower((string) $class);
        if ($class === 'form') {
            $className = 'TYPO3\\CMS\\Form\\Domain\\Model\\' . ucfirst($class);
        } elseif($class === 'recaptcha') {
            $className = 'Pixelant\\PxaT3formRecaptcha\\Domain\\Model\\RecaptchaElement';
        } else {
            $className = 'TYPO3\\CMS\\Form\\Domain\\Model\\Element\\' . ucfirst($class) . 'Element';
        }
        /** @var $object \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement */
        $object = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance($className);
        if ($object->getElementType() === \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement::ELEMENT_TYPE_CONTENT) {
            $object->setData($arguments['cObj'], $arguments['cObj.']);
        } elseif ($object->getElementType() === \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement::ELEMENT_TYPE_PLAIN) {
            $object->setProperties($arguments);
        } elseif ($object->getElementType() === \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement::ELEMENT_TYPE_FORM) {
            $object->setData($arguments['data']);
            $this->reconstituteElement($object, $arguments);
        } else {
            throw new \InvalidArgumentException('Element type "' . $object->getElementType() . '" is not supported.', 1333754878);
        }

        return $object;
    }

    /**
     * Create and add element by type.
     * This can be a derived Typoscript object by "<",
     * a form element, or a regular Typoscript object.
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement $parentElement The parent for the new element
     * @param string $class Classname for the element
     * @param array $arguments Configuration array
     * @return void
     */
    public function setElementType(\TYPO3\CMS\Form\Domain\Model\Element\AbstractElement $parentElement, $class, array $arguments) {
        if (in_array($class, FormUtility::getInstance()->getFormObjects())) {
            $this->addElement($parentElement, $class, $arguments);
        } elseif ($this->disableContentElement === FALSE) {
            if ($class[0] === '<') {
                $key = trim(substr($class, 1));
                /** @var $typoscriptParser \TYPO3\CMS\Core\TypoScript\Parser\TypoScriptParser */
                $typoscriptParser = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\TypoScript\\Parser\\TypoScriptParser');
                $oldArguments = $arguments;
                list($class, $arguments) = $typoscriptParser->getVal($key, $GLOBALS['TSFE']->tmpl->setup);
                if (is_array($oldArguments) && count($oldArguments)) {
                    $arguments = array_replace_recursive($arguments, $oldArguments);
                }
                $GLOBALS['TT']->incStackPointer();
                $contentObject = array(
                    'cObj' => $class,
                    'cObj.' => $arguments
                );
                $this->addElement($parentElement, 'content', $contentObject);
                $GLOBALS['TT']->decStackPointer();
            } else {
                $contentObject = array(
                    'cObj' => $class,
                    'cObj.' => $arguments
                );
                $this->addElement($parentElement, 'content', $contentObject);
            }
        }
    }
}