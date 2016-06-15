<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 9:59
 */

namespace Pixelant\PxaFormEnhancement\Domain\Model;


class RecaptchaElement extends \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement {

    /**
     * Allowed attributes for this object
     *
     * @var array
     */
    protected $allowedAttributes = array(
        'class' => 'g-recaptcha',
        'id' => 'g-recaptcha'
    );

    /**
     * fake , just to avoid error
     *
     * @return string
     */
    public function getData() {
        return '';
    }
}