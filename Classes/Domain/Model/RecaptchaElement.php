<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 9:59
 */

namespace Pixelant\PxaFormEnhancement\Domain\Model;


use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility;

class RecaptchaElement extends \TYPO3\CMS\Form\Domain\Model\Element\AbstractElement {

    /**
     * recaptcha url
     */
    const RECAPTCHA_URL = 'https://www.google.com/recaptcha/api.js?onload=onloadCallbackRecaptcha&render=explicit';

    /**
     * If need to init JS
     *
     * @var bool
     */
    private static $needInit = true;

    /**
     * Allowed attributes for this object
     *
     * @var array
     */
    protected $allowedAttributes = array(
        'class' => 'g-recaptcha',
        'id' => 'g-recaptcha'
    );

    /**
     * fake , just to init JS
     *
     * @return string
     */
    public function getData() {
        $message = $this->iniJs();
        return $message;
    }

    /**
     * Add JS for recaptcha
     *
     * @return string
     */
    protected function iniJs()
    {
        if (true === self::$needInit) {
            $configuration = ConfigurationUtility::getConfiguration();

            if ($configuration['siteKey'] && $configuration['siteSecret']) {
                /** @var PageRenderer $pageRenderer */
                $pageRenderer = GeneralUtility::makeInstance(PageRenderer::class);

                $pageRenderer->addJsFooterInlineCode(
                    'pxa_form_enhancement',
                    sprintf(
                        $this->getJsInitTemplate(),
                        $configuration['siteKey']
                    )
                );

                $pageRenderer->addJsFooterFile(
                    self::RECAPTCHA_URL,
                    'text/javascript',
                    false,
                    false,
                    '',
                    true
                );

                $message = '';
                self::$needInit = false;
            } else {
                $message = LocalizationUtility::translate('fe.error.credentials_not_set', 'pxa_form_enhancement');
            }

            return $message;
        }

        return '';
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
    if (document.getElementById(\'g-recaptcha\')) {
        grecaptcha.render(
            \'g-recaptcha\',
             {\'sitekey\': \'%s\'}
        );
    }
};';
    }
}