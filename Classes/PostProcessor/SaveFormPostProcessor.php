<?php

namespace Pixelant\PxaFormEnhancement\PostProcessor;

use TYPO3\CMS\Core\Utility\GeneralUtility,
    TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\MathUtility;


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
class SaveFormPostProcessor implements \TYPO3\CMS\Form\PostProcess\PostProcessorInterface {

    /**
     * extension name
     */
    const EXT_NAME = 'pxa_form_enhancement';

    /**
     * @var \TYPO3\CMS\Form\Domain\Model\Form
     */
    protected $form;

    /**
     * @var array
     */
    protected $typoScript;

    /**
     * model to save
     *
     * @var \Pixelant\PxaFormEnhancement\Domain\Model\Form
     */
    protected $formModel = NULL;

    /**
     * model to save
     *
     * @var \Pixelant\PxaFormEnhancement\Domain\Repository\FormRepository
     */
    protected $formRepository = NULL;

    /**
     * persistenceManager
     *
     * @var \TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager
     */
    protected $persistenceManager = NULL;

    /**
     * fileReference
     *
     * @var \Pixelant\PxaFormEnhancement\Domain\Model\FileReference
     */
    protected $fileReference = NULL;

    /**
     * @var \TYPO3\CMS\Core\Resource\ResourceFactory
     */
    protected $resourceFactory;

    /**
     * objectManager
     *
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Form\Request
     */
    protected $requestHandler;

    /**
     * Constructor
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Form $form Form domain model
     * @param array $typoScript Post processor TypoScript settings
     */
    public function __construct(\TYPO3\CMS\Form\Domain\Model\Form $form, array $typoScript) {
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
        $this->requestHandler = GeneralUtility::makeInstance('TYPO3\\CMS\\Form\\Request');

        $this->objectManager = GeneralUtility::makeInstance('TYPO3\\CMS\\Extbase\\Object\\ObjectManager');

        $this->formModel = $this->objectManager->get('Pixelant\\PxaFormEnhancement\\Domain\\Model\\Form');
        $this->formRepository = $this->objectManager->get('Pixelant\\PxaFormEnhancement\\Domain\\Repository\\FormRepository');
        $this->resourceFactory = $this->objectManager->get('TYPO3\\CMS\\Core\\Resource\\ResourceFactory');
        $this->persistenceManager = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\PersistenceManager');
    }

    /**
     * The main method called by the post processor
     *
     * @return string HTML message from this processor
     */
    public function process() {
        $formElements = $this->form->getElements();
        $submittedValues = $this->requestHandler->getByMethod();
        $count = $this->formRepository->countByPid($this->typoScript['pid']);
        $text = '';

        $this->processFields($formElements, $text, $submittedValues);

        $this->formModel->setName((empty($this->typoScript['defaultName']) ? LocalizationUtility::translate('label.newFormname',self::EXT_NAME) : $this->typoScript['defaultName']) . ' #' . ++$count);
        $this->formModel->setFormData($text);
        $this->formModel->setPid($this->typoScript['pid']);

        $this->formRepository->add($this->formModel);

        $this->persistenceManager->persistAll();

        return '';
    }

    /**
     * process fields
     * @param array $formElements
     * @param string $text
     * @param array $submittedValues
     */
    protected function processFields($formElements, &$text, $submittedValues) {
        foreach ($formElements as $element) {
            if(is_a($element,'TYPO3\\CMS\\Form\\Domain\\Model\\Element\\ContainerElement')) {
                
                if ( !empty($element->getAdditionalObjectByKey('legend')) ) {
                    if($element->getAdditionalObjectByKey('legend')->getValue()) {
                        $text .= $element->getAdditionalObjectByKey('legend')->getValue() . "\n";
                    }    
                } 
                
                $this->processFields($element->getElements(), $text, $submittedValues);
            } elseif (is_a($element,'TYPO3\\CMS\\Form\\Domain\\Model\\Element\\RadioElement')) {
                $name = $element->getName();
                $value = $element->getValue();

                if(isset($submittedValues[$name]) && $submittedValues[$name] == $value) {
                    $text .= $element->getAdditionalObjectByKey('label')->getValue() . "\n";
                }
            } elseif (is_a($element,'TYPO3\\CMS\\Form\\Domain\\Model\\Element\\TextareaElement')) {
                $name = $element->getName();
                $text .= $element->getAdditionalObjectByKey('label')->getValue() . "\n" . $submittedValues[$name] . "\n";
            } elseif (is_a($element,'TYPO3\\CMS\\Form\\Domain\\Model\\Element\\TextlineElement')) {
                $name = $element->getName();
                $text .= $element->getAdditionalObjectByKey('label')->getValue() . ' ' . $submittedValues[$name] . "\n";
            } elseif (is_a($element,'TYPO3\\CMS\\Form\\Domain\\Model\\Element\\FileuploadElement')) {
                $name = $element->getName();

                if(isset($submittedValues[$name]['tempFilename']) && !empty($submittedValues[$name]['tempFilename'])) {
                    /** @var \Pixelant\PxaFormEnhancement\Domain\Model\FileReference $fileReferenceModel */
                    $fileReferenceModel = $this->objectManager->get('Pixelant\\PxaFormEnhancement\\Domain\\Model\\FileReference');

                    /** @var \TYPO3\CMS\Core\Resource\ResourceStorage $storage */
                    $storage = GeneralUtility::makeInstance('TYPO3\\CMS\\Core\\Resource\\StorageRepository')->findByUid($this->typoScript['storageUid']);

                    $fileObject = $storage->addFile($submittedValues[$name]['tempFilename'], $storage->getFolder($this->typoScript['uploadFolder']) , $submittedValues[$name]['originalFilename']);

                    $fileReference = $this->resourceFactory->createFileReferenceObject(
                        array(
                            'uid_local' => $fileObject->getUid(),
                            'uid_foreign' => uniqid('NEW_'),
                            'uid' => uniqid('NEW_'),
                            'crop' => NULL
                        )
                    );
                    $fileReferenceModel->setOriginalResource($fileReference);
                    $fileReferenceModel->setPid((int)$this->typoScript['pid']);

                    $this->formModel->setAttachment($fileReferenceModel);
                }
            }
        }
    }
}