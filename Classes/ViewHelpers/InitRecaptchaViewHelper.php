<?php

namespace Pixelant\PxaFormEnhancement\ViewHelpers;

use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

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
class InitRecaptchaViewHelper extends AbstractViewHelper
{
    /**
     * recaptcha url
     */
    const RECAPTCHA_URL = 'https://www.google.com/recaptcha/api.js?onload=onloadCallbackRecaptcha&render=explicit';

    /**
     * Initialize
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('recaptchaIdentifier', 'string', 'Unique identifier for recaptcha element', true);
    }

    /**
     * Add JS for recaptcha
     *
     * @return string
     */
    public function render()
    {
        $configuration = ConfigurationUtility::getConfiguration();

        if ($configuration['siteKey'] && $configuration['siteSecret']) {
            /** @var PageRenderer $pageRenderer */
            $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

            $pageRenderer->addJsFooterInlineCode(
                'pxa_form_enhancement',
                sprintf(
                    $this->getJsInitTemplate(),
                    $this->arguments['recaptchaIdentifier'],
                    $configuration['siteKey']
                )
            );

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

            $message = '';
        } else {
            $message = LocalizationUtility::translate('fe.error.credentials_not_set', 'pxa_form_enhancement');
        }

        return $message;
    }

    /**
     * Js template
     *
     * @return string
     */
    protected function getJsInitTemplate()
    {
        return '
var onloadCallbackRecaptcha = function() {
    grecaptcha.render(
        \'#%s\',
         {\'sitekey\': \'%s\'}
    );
};';
    }
}