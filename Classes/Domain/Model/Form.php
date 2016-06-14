<?php
namespace Pixelant\PxaFormEnhancement\Domain\Model;

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
 * Form
 */
class Form extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity {

    /**
     * name
     *
     * @var string
     */
    protected $name = '';

    /**
     * attachment
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FileReference
     */
    protected $attachment = null;

    /**
     * formData
     *
     * @var string
     */
    protected $formData = '';

    /**
     * Returns the attachment
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FileReference $attachment
     */
    public function getAttachment() {
        return $this->attachment;
    }

    /**
     * Sets the attachment
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FileReference $attachment
     * @return void
     */
    public function setAttachment(\TYPO3\CMS\Extbase\Domain\Model\FileReference $attachment) {
        $this->attachment = $attachment;
    }

    /**
     * Returns the formData
     *
     * @return string $formData
     */
    public function getFormData() {
        return $this->formData;
    }

    /**
     * Sets the formData
     *
     * @param string $formData
     * @return void
     */
    public function setFormData($formData) {
        $this->formData = $formData;
    }

    /**
     * Returns the name
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Sets the name
     *
     * @param string $name
     * @return void
     */
    public function setName($name) {
        $this->name = $name;
    }

}