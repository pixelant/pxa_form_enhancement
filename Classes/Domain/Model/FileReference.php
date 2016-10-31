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
 * Class FileReference
 * @package Pixelant\PxaFormEnhancement\Domain\Model
 */
class FileReference extends \TYPO3\CMS\Extbase\Domain\Model\FileReference {

	/**
	 * Uid of a sys_file
	 *
	 * @var integer
	 */
	protected $uidLocal;

	/**
	 * tablenames
	 *
	 * @var string
	 */
	protected $tablenames = 'tx_pxaformenhancement_domain_model_form';
	
	/**
	 * tableLocal
	 *
	 * @var string
	 */
	protected $tableLocal = 'sys_file';

	/**
	 * @param \TYPO3\CMS\Core\Resource\ResourceInterface $originalResource
	 */
	public function setOriginalResource(\TYPO3\CMS\Core\Resource\ResourceInterface $originalResource) {
		$this->originalResource = $originalResource;
		$this->uidLocal = (int)$originalResource->getOriginalFile()->getUid();
	}
}