<?php

namespace Pixelant\PxaFormEnhancement\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Andriy Oprysko <andriy@pixelant.se>, Pixelant
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class \Pixelant\PxaFormEnhancement\Domain\Model\Form.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 * @author Andriy Oprysko <andriy@pixelant.se>
 */
class FormTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \Pixelant\PxaFormEnhancement\Domain\Model\Form
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \Pixelant\PxaFormEnhancement\Domain\Model\Form();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getNameReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getName()
		);
	}

	/**
	 * @test
	 */
	public function setNameForStringSetsName()
	{
		$this->subject->setName('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'name',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getAttachmentReturnsInitialValueForFileReference()
	{
		$this->assertEquals(
			NULL,
			$this->subject->getAttachment()
		);
	}

	/**
	 * @test
	 */
	public function setAttachmentForFileReferenceSetsAttachment()
	{
		$fileReferenceFixture = new \TYPO3\CMS\Extbase\Domain\Model\FileReference();
		$this->subject->setAttachment($fileReferenceFixture);

		$this->assertAttributeEquals(
			$fileReferenceFixture,
			'attachment',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getFormDataReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getFormData()
		);
	}

	/**
	 * @test
	 */
	public function setFormDataForStringSetsFormData()
	{
		$this->subject->setFormData('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'formData',
			$this->subject
		);
	}
}
