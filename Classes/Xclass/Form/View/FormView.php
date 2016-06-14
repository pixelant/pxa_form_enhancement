<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 10:47
 */

namespace Pixelant\PxaT3formRecaptcha\Xclass\Form\View;


class FormView extends \Pixelant\PxaT3formRecaptcha\Xclass\Form\View\Element\ContainerElementView {

    /**
     * @var string
     */
    protected $expectedModelName = 'TYPO3\\CMS\\Form\\Domain\\Model\\Form';

    /**
     * Default layout of this object
     *
     * @var string
     */
    protected $layout = '
		<form>
			<containerWrap />
		</form>';

    /**
     * Set the data for the FORM tag
     *
     * @param \TYPO3\CMS\Form\Domain\Model\Form $formModel The model of the form
     * @return void
     */
    public function setData(\TYPO3\CMS\Form\Domain\Model\Form $model) {
        $this->model = (object) $model;
    }

    /**
     * Start the main DOMdocument for the form
     * Return it as a string using saveXML() to get a proper formatted output
     * (when using formatOutput :-)
     *
     * @return string XHTML string containing the whole form
     */
    public function get() {
        $node = $this->render('element', FALSE);
        $content = chr(10) . html_entity_decode($node->saveXML($node->firstChild), ENT_QUOTES, 'UTF-8') . chr(10);
        return $content;
    }
}