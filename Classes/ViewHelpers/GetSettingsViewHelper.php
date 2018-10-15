<?php
declare(strict_types=1);

namespace Pixelant\PxaFormEnhancement\ViewHelpers;

use Pixelant\PxaFormEnhancement\Utility\ConfigurationUtility;
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
 * Class GetSettingsViewHelper
 * @package Pixelant\PxaFormEnhancement\ViewHelpers
 */
class GetSettingsViewHelper extends AbstractViewHelper
{
    use CompileWithRenderStatic;

    /**
     * @var boolean
     */
    protected $escapeChildren = false;

    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Register arguments
     */
    public function initializeArguments()
    {
        $this->registerArgument('as', 'string', 'Render settings as variable');
    }

    /**
     * Get settings of pxa_form_enhancement
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(
        array $arguments,
        \Closure $renderChildrenClosure,
        RenderingContextInterface $renderingContext
    ) {
        $as = $arguments['as'];
        $settings = ConfigurationUtility::getConfiguration();

        if (!empty($as)) {
            $variableProvider = $renderingContext->getVariableProvider();
            if ($variableProvider->exists($as)) {
                $variableProvider->remove($as);
            }

            $variableProvider->add($as, $settings);
            $content = $renderChildrenClosure();
            $variableProvider->remove($as);

            return $content;
        }

        return $settings;
    }
}
