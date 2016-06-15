<?php
namespace Pixelant\PxaFormEnhancement\Form\PostProcess;

use Pixelant\PxaFormEnhancement\Domain\Model\FileReference;
use Pixelant\PxaFormEnhancement\Domain\Model\Form;
use Pixelant\PxaFormEnhancement\Domain\Repository\FormRepository;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Core\Resource\StorageRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Form\PostProcess\PostProcessorInterface;
use TYPO3\CMS\Form\PostProcess\AbstractPostProcessor;


/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2014
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
 * Save form
 */
class SaveFormPostProcessorEnhancement extends AbstractPostProcessor implements PostProcessorInterface {

    /**
     * extension name
     */
    const EXT_NAME = 'pxa_form_enhancement';

    /**
     * container elements list
     */
    const CONTAINER_ELEMENTS_LIST = 'RADIOGROUP,CHECKBOXGROUP,FIELDSET';

    /**
     * radio input
     */
    const ELEMENT_TYPE_RADIO = 'RADIO';

    /**
     * checkbox input
     */
    const ELEMENT_TYPE_CHECKBOX = 'CHECKBOX';

    /**
     * simple input
     */
    const ELEMENT_TYPE_INPUT = 'TEXTLINE';

    /**
     * checkbox textarea
     */
    const ELEMENT_TYPE_TEXTAREA = 'TEXTAREA';

    /**
     * checkbox file upload
     */
    const ELEMENT_TYPE_FILEUPLOAD = 'FILEUPLOAD';

	/**
	 * @var \TYPO3\CMS\Form\Domain\Model\Element
	 */
	protected $form;

	/**
	 * @var array
	 */
	protected $typoScript;

	/**
	 * model to save
	 *
	 * @var Form
	 */
	protected $formModel = NULL;

	/**
	 * model to save
	 *
	 * @var FormRepository
	 */
	protected $formRepository = NULL;

	/**
	 * fileReference
	 *
	 * @var FileReference
	 */
	protected $fileReference = NULL;

	/**
	 * @var ResourceFactory
	 */
	protected $resourceFactory;

	/**
	 * objectManager
	 *
	 * @var ObjectManager $objectManager
	 */
	protected $objectManager;



    /**
     * Constructor
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Element $form Form domain model
     * @param array $typoScript Post processor TypoScript settings
     */
    public function __construct(\TYPO3\CMS\Form\Domain\Model\Element $form, array $typoScript) {
        if(!MathUtility::canBeInterpretedAsInteger($typoScript['pid'])) {
            throw new \InvalidArgumentException(
                'Pid value "' . $this->typoScript['pid'] . '" is not valid.',
                1465820172
            );
        } else {
            $typoScript['pid'] = intval($typoScript['pid']);
        }
        // init settings for files attachments
        $typoScript['storageUid'] = (isset($typoScript['storageUid']) && MathUtility::canBeInterpretedAsInteger($typoScript['storageUid'])) ? intval($typoScript['storageUid']) : 1;
        $typoScript['uploadFolder'] = !empty($typoScript['uploadFolder']) ? trim($typoScript['uploadFolder']) : 'user_upload';

        $this->form = $form;
        $this->typoScript = $typoScript;
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        $this->formModel = $this->objectManager->get(Form::class);
        $this->formRepository = $this->objectManager->get(FormRepository::class);
        $this->resourceFactory = $this->objectManager->get(ResourceFactory::class);
    }

	/**
	 * The main method called by the post processor
	 *
	 * @return string HTML message from this processor
	 */
	public function process() {
		$formElements = $this->form->getChildElements();
		$count = $this->formRepository->countByPid($this->typoScript['pid']);
		$text = '';

		$this->processFields($formElements, $text);

		$this->formModel->setName((empty($this->typoScript['defaultName']) ? LocalizationUtility::translate('label.newFormname',self::EXT_NAME) : $this->typoScript['defaultName']) . ' #' . ++$count);
		$this->formModel->setFormData($text);
		$this->formModel->setPid($this->typoScript['pid']);

		$this->formRepository->add($this->formModel);

		GeneralUtility::makeInstance(PersistenceManager::class)->persistAll();

		return '';
	}

	/**
	 * process fields
	 * @param ObjectStorage $formElements
	 * @param string $text
	 */
	protected function processFields(ObjectStorage $formElements, &$text) {
        /** @var \TYPO3\CMS\Form\Domain\Model\Element $element */
        foreach ($formElements as $element) {
			if(GeneralUtility::inList(self::CONTAINER_ELEMENTS_LIST, $element->getElementType()) && $element->getChildElements()->count() > 0) {
                if($legend = $element->getAdditionalArgument('legend')) {
                    $text .= "\n" . $legend . "\n";
                }
				$this->processFields($element->getChildElements(), $text);
			} elseif ($element->getElementType() === self::ELEMENT_TYPE_RADIO || $element->getElementType() === self::ELEMENT_TYPE_CHECKBOX) {
                $additionalArguments = $element->getAdditionalArguments();

				if($additionalArguments['checked'] && $additionalArguments['label']) {
					$text .=  $additionalArguments['label'] . "\n";
				}

			} elseif ($element->getElementType() === self::ELEMENT_TYPE_INPUT) {
                $additionalArguments = $element->getAdditionalArguments();
				$text .= $additionalArguments['label'] . ': ' . $additionalArguments['value'] . "\n";

			} elseif ($element->getElementType() === self::ELEMENT_TYPE_TEXTAREA) {
                $additionalArguments = $element->getAdditionalArguments();
                $text .= $additionalArguments['label'] . ":\n" . $additionalArguments['value'] . "\n";

            } elseif ($element->getElementType() === self::ELEMENT_TYPE_FILEUPLOAD) {
                $additionalArguments = $element->getAdditionalArguments();

                if(count($additionalArguments['uploadedFiles']) > 0 && $additionalArguments['uploadedFiles'][0]['tempFilename']) {
                    $this->createFileReference($additionalArguments);
                }
			}
		}
	}

    /**
     * @param array $additionalArguments
     * @return void
     */
    protected function createFileReference($additionalArguments) {
        /** @var FileReference $fileReference */
        $fileReference = $this->objectManager->get(FileReference::class);

        /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
        $storage = GeneralUtility::makeInstance(StorageRepository::class)->findByUid($this->typoScript['storageUid']);

        /** @var File $fileObject */
        $fileObject = $storage->addFile($additionalArguments['uploadedFiles'][0]['tempFilename'], $storage->getFolder($this->typoScript['uploadFolder']) , $additionalArguments['uploadedFiles'][0]['name']);

        $fileReferenceObject = $this->resourceFactory->createFileReferenceObject(
            [
                'uid_local' => $fileObject->getUid(),
                'uid_foreign' => uniqid('NEW_'),
                'uid' => uniqid('NEW_')
            ]
        );

        $fileReference->setOriginalResource($fileReferenceObject);
        $fileReference->setPid($this->typoScript['pid']);

        $this->formModel->setAttachment($fileReference);
    }
}