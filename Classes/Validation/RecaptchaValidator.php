<?php

namespace Pixelant\PxaFormEnhancement\Validation;

use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
use TYPO3\CMS\Core\Http\RequestFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator;

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
class RecaptchaValidator extends AbstractValidator
{

    /**
     * Check recaptcha
     *
     * @param mixed $value Recaptcha doesn't have value
     * @return void
     */
    public function isValid($value = null)
    {
        $isValid = false;
        $recaptchaCode = GeneralUtility::_GP('g-recaptcha-response');
        $configuration = ConfigurationUtility::getConfiguration();
        $siteSecret = $configuration['siteSecret'];

        if ($recaptchaCode && $siteSecret) {
            /** @var RequestFactory $httpRequest */
            $requestFactory = GeneralUtility::makeInstance(RequestFactory::class);

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
                $recaptchaResult = json_decode($response->getBody(), true);

                $isValid = (bool)$recaptchaResult['success'];
            }
        }

        if (!$isValid) {
            $this->addError(
                $this->translateErrorMessage(
                    'fe.error.recaptcha',
                    'PxaFormEnhancement'
                ),
                1465905014
            );
        }
    }
}
