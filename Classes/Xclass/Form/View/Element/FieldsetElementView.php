<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 11:46
 */

namespace Pixelant\PxaT3formRecaptcha\Xclass\Form\View\Element;


class FieldsetElementView extends ContainerElementView {

    /**
     * Default layout of this object
     *
     * @var string
     */
    protected $layout = '
		<fieldset>
			<legend />
			<containerWrap />
		</fieldset>
	';

}