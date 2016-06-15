<?php

namespace Pixelant\PxaFormEnhancement\ViewHelpers;


use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;

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