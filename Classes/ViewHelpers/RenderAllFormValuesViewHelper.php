<?php
declare(strict_types=1);

namespace Pixelant\PxaFormEnhancement\ViewHelpers;

use TYPO3\CMS\Form\Domain\Model\Renderable\CompositeRenderableInterface;
use TYPO3\CMS\Form\ViewHelpers\RenderAllFormValuesViewHelper as FormRenderAllFormValuesViewHelper;
use TYPO3\CMS\Form\ViewHelpers\RenderFormValueViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;

/**
 * Override Form ViewHelper in order to exclude Recaptcha in emails and summary page
 */
class RenderAllFormValuesViewHelper extends FormRenderAllFormValuesViewHelper
{
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $renderable = $arguments['renderable'];

        if ($renderable instanceof CompositeRenderableInterface) {
            $elements = $renderable->getRenderablesRecursively();
        } else {
            $elements = [$renderable];
        }

        $as = $arguments['as'];
        $output = '';

        foreach ($elements as $element) {
            if ($element->getType() === 'Recaptcha') {
                continue;
            }

            $output .= RenderFormValueViewHelper::renderStatic(
                [
                    'renderable' => $element,
                    'as' => $as,
                ],
                $renderChildrenClosure,
                $renderingContext
            );
        }

        return $output;
    }
}
