<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 10:13
 */

namespace Pixelant\PxaFormEnhancement\Xclass\Form\View\Element;


class RecaptchaElementView extends AbstractElementView {



    /**
     * @var string
     */
    protected $expectedModelName = 'Pixelant\\PxaFormEnhancement\\Domain\\Model\\RecaptchaElement';

    /**
     * Default layout of this object
     *
     * @var string
     */
    protected $layout = '
		<label />
		<div />
		<error />
	';
}