<?php

namespace Pixelant\PxaFormEnhancement\ViewHelpers;


use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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

class InitRecaptchaViewHelper extends  \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * js to init recaptcha
     */
    const JS_INLINE = 'var onloadCallbackRecaptcha = function() {grecaptcha.render(\'{id}\', {\'sitekey\': \'{sitekey}\'});};';

    /**
     * recaptcha url
     */
    const RECAPTCHA_URL = 'https://www.google.com/recaptcha/api.js?onload=onloadCallbackRecaptcha&render=explicit';

    /**
     * add JS for recaptcha
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Element $recaptcha
     * @return void
     */
    public function render(\TYPO3\CMS\Form\Domain\Model\Element $recaptcha) {
        $configuration = ConfigurationUtility::getConfiguration();

        if($configuration['siteKey'] && $configuration['siteSecret']) {
            /** @var PageRenderer $pageRenderer */
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);
            $pageRenderer->addJsFooterInlineCode('pxa_form_enhancement', str_replace(['{id}', '{sitekey}'], [$recaptcha->getAdditionalArgument('id'), $configuration['siteKey']], self::JS_INLINE), false, false);
            $pageRenderer->addJsFooterFile(
                self::RECAPTCHA_URL,
                'text/javascript',
                false,
                false,
                '',
                true,
                '|',
                true
            );
        }
    }
}