<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 13:55
 */

namespace Pixelant\PxaFormEnhancement\Validation;


use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Http\HttpRequest;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class RecaptchaValidator extends \TYPO3\CMS\Form\Validation\AbstractValidator {
    
    /**
     * Constant for localisation
     *
     * @var string
     */
    const LOCALISATION_OBJECT_NAME = 'tx_form_system_validate_required';

    /**
     * Returns TRUE if recaptcha is no robot
     *
     * @return boolean
     * @see \TYPO3\CMS\Form\Validation\ValidatorInterface::isValid()
     */
    public function isValid() {
        $recaptchaCode = GeneralUtility::_GP('g-recaptcha-response');
        $configuration = ConfigurationUtility::getConfiguration();
        $siteSecret = $configuration['siteSecret'];

        if($recaptchaCode && $siteSecret) {
            /** @var HttpRequest $httpRequest */
            $httpRequest = GeneralUtility::makeInstance('TYPO3\CMS\Core\Http\HttpRequest', 'https://www.google.com/recaptcha/api/siteverify', HttpRequest::METHOD_POST);
            $httpRequest->addPostParameter('response', $recaptchaCode)
                        ->addPostParameter('secret', $siteSecret)
                        ->addPostParameter('remoteip', $_SERVER['REMOTE_ADDR']);

            try {
                /** @var \HTTP_Request2_Response $response */
                $response = $httpRequest->send();

                if ($response->getStatus() === 200) {
                    $recaptchaResult = json_decode($response->getBody(), TRUE);

                    return $recaptchaResult['success'];
                }
            } catch (\Exception $e) {
                // will be not valid
            }
        }

        return FALSE;
    }
}