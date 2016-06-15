<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 12:24
 */

namespace Pixelant\PxaFormEnhancement\Xclass\Utility;


class FormUtility extends \TYPO3\CMS\Form\Utility\FormUtility {

    /**
     * Gets a singleton instance of this object.
     *
     * @return \TYPO3\CMS\Form\Utility\FormUtility
     */
    static public function getInstance() {
        return \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(__CLASS__);
    }

    /**
     * Initializes this object.
     */
    public function __construct() {
        $this->setFormObjects(array(
            'BUTTON',
            'CHECKBOX',
            'CHECKBOXGROUP',
            'FIELDSET',
            'FILEUPLOAD',
            'FORM',
            'FORM_INT',
            'HEADER',
            'HIDDEN',
            'IMAGEBUTTON',
            'OPTGROUP',
            'OPTION',
            'PASSWORD',
            'RADIO',
            'RADIOGROUP',
            'RESET',
            'SELECT',
            'SUBMIT',
            'TEXTAREA',
            'TEXTBLOCK',
            'TEXTLINE',
            'RECAPTCHA'
        ));
    }
}