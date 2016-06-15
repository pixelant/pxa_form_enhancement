<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 14.06.16
 * Time: 10:02
 */

namespace Pixelant\PxaFormEnhancement\Hooks;

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
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Form\View\Wizard\WizardView;

/**
 * Class WizardExtendView
 * extend form wizrd class to add more js files

 * @package Pixelant\PxaFormEnhancement\Form\View
 */
class WizardViewHook {

    /**
     * @var PageRenderer
     */
    protected $pageRenderer;

    public function __construct() {
        $this->pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
    }

    /**
     * hook to add additional JS files and translations
     *
     * @param array $params
     * @param WizardView $wizardView
     * @return void
     */
    public function renderHook($params, WizardView $wizardView) {
        $this->loadProcessorJsFiles();
        $this->loadCss();
        $this->loadLocalization();
    }

    /**
     * @return void
     */
    protected function loadProcessorJsFiles() {
        $baseUrl = ExtensionManagementUtility::extRelPath('pxa_form_enhancement');
        $jsFiles = [
            $baseUrl . 'Resources/Public/JavaScript/Wizard/PostProcessor/SaveForm.js',
            $baseUrl . 'Resources/Public/JavaScript/Wizard/Elements/Basic.js',
            $baseUrl . 'Resources/Public/JavaScript/Wizard/Elements/Recaptcha.js',
            $baseUrl . 'Resources/Public/JavaScript/Wizard/Validation/Recaptcha.js'
        ];

        foreach ($jsFiles as $file) {
            $this->pageRenderer->addJsFile($file, 'text/javascript', true, false);
        }
    }

    /**
     * @return void
     */
    protected function loadLocalization() {
        $wizardLabels = $this->getLanguageService()->includeLLFile('EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf', false, true);
        $this->pageRenderer->addInlineLanguageLabelArray($wizardLabels['default']);
    }

    /**
     * Load the necessary css
     *
     * This will only be done when the referenced record is available
     *
     * @return void
     */
    protected function loadCss() {
        $baseUrl = ExtensionManagementUtility::extRelPath('pxa_form_enhancement');
        $cssFiles = [
            $baseUrl . 'Resources/Public/Css/Wizard/basic.css'
        ];

        // Load the wizards css
        foreach ($cssFiles as $cssFile) {
            $this->pageRenderer->addCssFile($cssFile, 'stylesheet', 'all', '', false, false);
        }
    }

    /**
     * Returns an instance of LanguageService
     *
     * @return \TYPO3\CMS\Lang\LanguageService
     */
    protected function getLanguageService() {
        return $GLOBALS['LANG'];
    }
}