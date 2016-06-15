<?php

namespace Pixelant\PxaFormEnhancement\Utility;

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
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Class ConfigurationUtility
 * @package Pixelant\PxaFormEnhancement\Utility
 */
class ConfigurationUtility {

    /**
     * @var array $plugin configuration
     */
    static protected $configuration = NULL;

    /**
     * get plugin configuration
     */
    static public function getConfiguration() {
        if(self::$configuration === NULL) {
            self::$configuration = is_array($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_pxaformenhancement.']['settings.']) ? GeneralUtility::removeDotsFromTS($GLOBALS['TSFE']->tmpl->setup['plugin.']['tx_pxaformenhancement.']['settings.']) : [];
        }

        return self::$configuration;
    }
}