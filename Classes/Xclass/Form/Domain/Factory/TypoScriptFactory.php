<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 15.06.16
 * Time: 14:04
 */

namespace Pixelant\PxaFormEnhancement\Xclass\Form\Domain\Factory;


use Pixelant\PxaFormEnhancement\Xclass\Utility\FormUtility;

class TypoScriptFactory extends \TYPO3\CMS\Form\Domain\Factory\TypoScriptFactory {

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