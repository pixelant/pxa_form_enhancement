<?php
declare(strict_types=1);

namespace Pixelant\PxaFormEnhancement\Domain\Finishers;

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

use Pixelant\PxaFormEnhancement\Domain\Model\FileReference as AttachFileReference;
use Pixelant\PxaFormEnhancement\Domain\Model\Form;
use Pixelant\PxaFormEnhancement\Domain\Repository\FormRepository;
use TYPO3\CMS\Core\Resource\ResourceFactory;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;
use TYPO3\CMS\Form\Domain\Model\FormElements\FileUpload;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use TYPO3\CMS\Form\Service\TranslationService;
use TYPO3\CMS\Form\ViewHelpers\RenderRenderableViewHelper;

/**
 * This finisher redirects to another Controller.
 *
 * Scope: frontend
 */
class SaveFormFinisher extends AbstractFinisher
{

    /**
     * @var array
     */
    protected $defaultOptions = [
        'pageUid' => 1,
        'name' => '',
    ];

    /**
     * @var FormRepository
     */
    protected $formRepository;

    /**
     * @var ResourceFactory
     */
    protected $resourceFactory;

    /**
     * @var Form
     */
    protected $saveForm;

    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     */
    protected function executeInternal()
    {
        $this->formRepository = $this->objectManager->get(FormRepository::class);
        $this->resourceFactory = $this->objectManager->get(ResourceFactory::class);
        $this->saveForm = $this->objectManager->get(Form::class);

        $count = $this->formRepository->countByPid((int)$this->options['pageUid']);



        $formRuntime = $this->finisherContext->getFormRuntime();
        $standaloneView = $this->initializeStandaloneView($formRuntime);

        $translationService = TranslationService::getInstance();
        if (isset($this->options['translation']['language']) && !empty($this->options['translation']['language'])) {
            $languageBackup = $translationService->getLanguage();
            $translationService->setLanguage($this->options['translation']['language']);
        }

        $message = trim($standaloneView->render());

        if (!empty($languageBackup)) {
            $translationService->setLanguage($languageBackup);
        }

        $this->saveForm->setFormData($message);
        $this->saveForm->setPid($this->options['pageUid']);
        $this->saveForm->setName($this->options['name'] . ' #' . ++$count);

        $this->attachFiles($formRuntime);

        $this->formRepository->add($this->saveForm);

        $this->objectManager->get(PersistenceManager::class)->persistAll();
    }

    /**
     * Attach files
     *
     * @param FormRuntime $formRuntime
     */
    protected function attachFiles(FormRuntime $formRuntime)
    {
        $elements = $formRuntime->getFormDefinition()->getRenderablesRecursively();

        foreach ($elements as $element) {
            if ($element instanceof FileUpload) {
                $file = $formRuntime[$element->getIdentifier()];

                if ($file) {
                    /** @var AttachFileReference $attachment */
                    $attachment = $this->objectManager->get(AttachFileReference::class);

                    if ($file instanceof FileReference) {
                        $file = $file->getOriginalResource();
                    }

                    $newFileReferenceObject = $this->resourceFactory->createFileReferenceObject(
                        [
                            'uid_local' => $file->getOriginalFile()->getUid(),
                            'uid_foreign' => uniqid('NEW_'),
                            'uid' => uniqid('NEW_')
                        ]
                    );

                    $attachment->setOriginalResource($newFileReferenceObject);
                    $attachment->setPid($this->options['pid']);

                    $this->saveForm->addAttachment($attachment);
                }
            }
        }
    }

    /**
     * @param FormRuntime $formRuntime
     * @return StandaloneView
     * @throws FinisherException
     */
    protected function initializeStandaloneView(FormRuntime $formRuntime): StandaloneView
    {
        if (!isset($this->options['templatePathAndFilename'])) {
            throw new FinisherException(
                'The option "templatePathAndFilename" must be set for the EmailFinisher.',
                1327058829
            );
        }

        /** @var StandaloneView $standaloneView */
        $standaloneView = $this->objectManager->get(StandaloneView::class);
        $standaloneView->setTemplatePathAndFilename($this->options['templatePathAndFilename']);
        $standaloneView->assign('finisherVariableProvider', $this->finisherContext->getFinisherVariableProvider());

        if (isset($this->options['partialRootPaths']) && is_array($this->options['partialRootPaths'])) {
            $standaloneView->setPartialRootPaths($this->options['partialRootPaths']);
        }

        if (isset($this->options['layoutRootPaths']) && is_array($this->options['layoutRootPaths'])) {
            $standaloneView->setLayoutRootPaths($this->options['layoutRootPaths']);
        }

        if (isset($this->options['variables'])) {
            $standaloneView->assignMultiple($this->options['variables']);
        }

        $standaloneView->assign('form', $formRuntime);
        $standaloneView->getRenderingContext()
            ->getViewHelperVariableContainer()
            ->addOrUpdate(RenderRenderableViewHelper::class, 'formRuntime', $formRuntime);

        return $standaloneView;
    }
}
