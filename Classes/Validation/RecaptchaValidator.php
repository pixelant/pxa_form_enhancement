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
use TYPO3\CMS\Core\Http\RequestFactory;
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

/**
 * Class RecaptchaValidator
 * @package Pixelant\PxaFormEnhancement\Validation
 */
class RecaptchaValidator extends \TYPO3\CMS\Form\Domain\Validator\AbstractValidator {

    /**
     * Constant for localization
     *
     * @var string
     */
    const LOCALISATION_OBJECT_NAME = 'tx_form_system_validate_required';

    /**
     * Returns TRUE if recaptcha is no robot
     *
     * @param mixed $value Recaptcha doesn't have value
     * @return void
     */
    public function isValid($value = NULL) {
        // skip recaptcha validation if it's from confirmation page
        $post = GeneralUtility::_POST('tx_form_form');
        if (!$post['confirmation-true']) {
            $recaptchaCode = GeneralUtility::_GP('g-recaptcha-response');
            $configuration = ConfigurationUtility::getConfiguration();
            $siteSecret = $configuration['siteSecret'];

            if ($recaptchaCode && $siteSecret) {
                /** @var RequestFactory $httpRequest */
                $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

                try {
                    /** @var \Psr\Http\Message\ResponseInterface $response */
                    $response = $requestFactory->request(
                        'https://www.google.com/recaptcha/api/siteverify',
                        'POST',
                        [
                            'form_params' => [
                                'response' => $recaptchaCode,
                                'secret' => $siteSecret,
                                'remoteip' => $_SERVER['REMOTE_ADDR']
                            ]
                        ]
                    );

                    if ($response->getStatusCode() === 200) {
                        $recaptchaResult = json_decode($response->getBody(), TRUE);

                        if ($recaptchaResult['success']) {
                            //exit if success
                            return;
                        }
                    }
                } catch (\Exception $e) {
                    // will be not valid
                }
            }

            $this->addErrorMessage();
        }
    }

    /**
     * add error message
     */
    protected function addErrorMessage() {
        $this->addError(
            $this->renderMessage(
                $this->options['errorMessage'][0],
                $this->options['errorMessage'][1],
                'error'
            ),
            1465905014
        );
    }
}