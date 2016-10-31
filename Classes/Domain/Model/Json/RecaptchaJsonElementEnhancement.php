<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 15.06.16
 * Time: 11:57
 */

namespace Pixelant\PxaFormEnhancement\Domain\Model\Json;

    /***************************************************************
     *
     *  Copyright notice
     *
     *  (c) 2016 Andriy Oprysko <andriy@pixelant.se>, Pixelant
     *
     *  All rights reserved
     *
     *  This script is part of the TYPO3 project. The TYPO3 project is
     *  free software; you can redistribute it and/or modify
     *  it under the terms of the GNU General Public License as published by
     *  the Free Software Foundation; either version 3 of the License, or
     *  (at your option) any later version.
     *
     *  The GNU General Public License can be found at
     *  http://www.gnu.org/copyleft/gpl.html.
     *
     *  This script is distributed in the hope that it will be useful,
     *  but WITHOUT ANY WARRANTY; without even the implied warranty of
     *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
     *  GNU General Public License for more details.
     *
     *  This copyright notice MUST APPEAR in all copies of the script!
     ***************************************************************/

/**
 * Class RecaptchaJsonElementEnhancement
 * @package Pixelant\PxaFormEnhancement\Domain\Model\Json
 */
class RecaptchaJsonElementEnhancement extends \TYPO3\CMS\Form\Domain\Model\Json\AbstractJsonElement {
    /**
     * The ExtJS xtype of the element
     *
     * @var string
     */
    public $xtype = 'typo3-form-wizard-elements-basic-recaptcha';

    /**
     * The configuration array for the xtype
     *
     * @var array
     */
    public $configuration = [
        'attributes' => [
            'type' => 'button'
        ],
        'filters' => [],
        'label' => [
            'value' => ''
        ],
        'layout' => 'front',
        'validation' => []
    ];

    /**
     * Allowed attributes for this object
     *
     * @var array
     */
    protected $allowedAttributes = [
        'accesskey',
        'class',
        'contenteditable',
        'contextmenu',
        'dir',
        'draggable',
        'dropzone',
        'hidden',
        'id',
        'lang',
        'spellcheck',
        'style',
        'tabindex',
        'title',
        'translate',
        /* element specific attributes */
        'autofocus',
        'disabled',
        'name',
        'type',
        'value'
    ];
}