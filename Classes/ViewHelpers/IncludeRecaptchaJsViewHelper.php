<?php
declare(strict_types=1);

namespace Pixelant\PxaFormEnhancement\ViewHelpers;

use TYPO3\CMS\Core\Page\PageRenderer;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithRenderStatic;

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
 * Class InitRecaptchaViewHelper
 * @package Pixelant\PxaFormEnhancement\ViewHelpers
 */
class IncludeRecaptchaJsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * recaptcha url
     */
    protected static $recaptchaUrl = 'https://www.google.com/recaptcha/api.js';

    /**
     * Add JS for recaptcha
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext): void
    {
        GeneralUtility::makeInstance(PageRenderer::class)
            ->addJsFile(static::$recaptchaUrl, 'text/javascript', false, false, '', true, '|', true, '', true);
    }
}
