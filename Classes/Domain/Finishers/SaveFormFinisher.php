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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\PersistenceManagerInterface;
use TYPO3\CMS\Fluid\View\StandaloneView;
use TYPO3\CMS\Form\Domain\Finishers\AbstractFinisher;
use TYPO3\CMS\Form\Domain\Finishers\Exception\FinisherException;
use TYPO3\CMS\Form\Domain\Model\FormElements\FileUpload;
use TYPO3\CMS\Form\Domain\Runtime\FormRuntime;
use TYPO3\CMS\Form\ViewHelpers\RenderRenderableViewHelper;

/**
 * This finisher redirects to another Controller.
 *
 * Scope: frontend
 */
class SaveFormFinisher extends AbstractFinisher
{

    protected $defaultOptions = [
        'pageUid' => 1,
        'name' => '',
    ];

    protected FormRepository $formRepository;
    protected ResourceFactory $resourceFactory;
    protected PersistenceManagerInterface $persistenceManager;

    protected Form $saveForm;

    /**
     * Storage for records
     */
    protected int $pid = 0;

    public function __construct(FormRepository $formRepository, ResourceFactory $resourceFactory, PersistenceManagerInterface $persistenceManager)
    {
        $this->formRepository = $formRepository;
        $this->resourceFactory = $resourceFactory;
        $this->persistenceManager = $persistenceManager;
    }

    /**
     * Executes this finisher
     * @see AbstractFinisher::execute()
     */
    protected function executeInternal(): void
    {
        $this->saveForm = GeneralUtility::makeInstance(Form::class);
        $this->pid = $this->getPid();

        $formRuntime = $this->finisherContext->getFormRuntime();
        $standaloneView = $this->initializeStandaloneView($formRuntime);

        $message = trim($standaloneView->render());

        $this->saveForm->setFormData($message);
        $this->saveForm->setPid($this->pid);
        $this->saveForm->setName(
            $this->generateName()
        );

        $this->attachFiles($formRuntime);

        $this->formRepository->add($this->saveForm);
        $this->persistenceManager->persistAll();
    }

    /**
     * Attach files
     *
     * @param FormRuntime $formRuntime
     */
    protected function attachFiles(FormRuntime $formRuntime): void
    {
        $elements = $formRuntime->getFormDefinition()->getRenderablesRecursively();

        foreach ($elements as $element) {
            if ($element instanceof FileUpload) {
                $file = $formRuntime[$element->getIdentifier()];

                if ($file) {
                    $attachment = GeneralUtility::makeInstance(AttachFileReference::class);

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
                    $attachment->setPid($this->pid);

                    $this->saveForm->addAttachment($attachment);
                }
            }
        }
    }

    /**
     * Get pid as storage
     *
     * @return int
     */
    protected function getPid(): int
    {
        if (GeneralUtility::isFirstPartOfStr($this->options['pageUid'], 'pages_')) {
            $pid = (int)substr($this->options['pageUid'], 6);
        } else {
            $pid = (int)$this->options['pageUid'];
        }

        return $pid;
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

        $standaloneView = GeneralUtility::makeInstance(StandaloneView::class);
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

    /**
     * @return string
     * @throws \TYPO3\CMS\Extbase\Persistence\Generic\Exception\InvalidNumberOfConstraintsException
     */
    protected function generateName(): string
    {
        $name = $this->parseOption('name');

        // If name is not found - set default
        if (!is_string($name)) {
            $name = 'Form';
        }

        // Add count postfix
        $existingNamesCount = $this->formRepository->countByNameSimilarity($this->pid, $name);
        if ($existingNamesCount > 0) {
            $name = $name . ' #' . ++$existingNamesCount;
        }

        return $name;
    }
}
