<?php
/**
 * Created by PhpStorm.
 * User: anjey
 * Date: 25.02.16
 * Time: 14:19
 */

namespace Pixelant\PxaT3formRecaptcha\Xclass\Form\View\Element;


class AbstractElementView extends \TYPO3\CMS\Form\View\Form\Element\AbstractElementView {
    /**
     * Parse the XML of a view object,
     * check the node type and name
     * and add the proper XML part of child tags
     * to the DOMDocument of the current tag
     *
     * @param \DOMDocument $dom
     * @param \DOMNode $reference Current XML structure
     * @return void
     */
    protected function parseXML(\DOMDocument $dom, \DOMNode $reference) {
        $node = $reference->firstChild;
        while (!is_null($node)) {
            $deleteNode = FALSE;
            $nodeType = $node->nodeType;
            $nodeName = $node->nodeName;
            switch ($nodeType) {
                case XML_TEXT_NODE:
                    break;
                case XML_ELEMENT_NODE:
                    switch ($nodeName) {
                        case 'containerWrap':
                            $this->replaceNodeWithFragment($dom, $node, $this->render('containerWrap'));
                            $deleteNode = TRUE;
                            break;
                        case 'elements':
                            $replaceNode = $this->getChildElements($dom);
                            $node->parentNode->replaceChild($replaceNode, $node);
                            break;
                        case 'button':

                        case 'fieldset':

                        case 'form':

                        case 'input':

                        case 'optgroup':

                        case 'select':
                            $this->setAttributes($node);
                            break;
                        case 'label':
                            if (!strrchr(get_class($this), 'AdditionalElement')) {
                                if ($this->model->additionalIsSet($nodeName)) {
                                    $this->replaceNodeWithFragment($dom, $node, $this->getAdditional('label'));
                                }
                                $deleteNode = TRUE;
                            } else {
                                if ($this->model->additionalIsSet($nodeName)) {
                                    $this->setAttributeWithValueofOtherAttribute($node, 'for', 'id');
                                } else {
                                    $deleteNode = TRUE;
                                }
                            }
                            break;
                        case 'legend':
                            if (!strrchr(get_class($this), 'AdditionalElement')) {
                                if ($this->model->additionalIsSet($nodeName)) {
                                    $this->replaceNodeWithFragment($dom, $node, $this->getAdditional('legend'));
                                }
                                $deleteNode = TRUE;
                            }
                            break;
                        case 'textarea':
                        case 'div':

                        case 'option':
                            if($nodeName == 'div' && $node->hasChildNodes()) {
                                break;
                            }

                            $this->setAttributes($node);
                            $appendNode = $dom->createTextNode($this->getElementData());
                            $node->appendChild($appendNode);
                            break;
                        case 'errorvalue':

                        case 'labelvalue':

                        case 'legendvalue':

                        case 'mandatoryvalue':
                            $replaceNode = $dom->createTextNode($this->getAdditionalValue());
                            $node->parentNode->insertBefore($replaceNode, $node);
                            $deleteNode = TRUE;
                            break;
                        case 'mandatory':

                        case 'error':
                            if ($this->model->additionalIsSet($nodeName)) {
                                $this->replaceNodeWithFragment($dom, $node, $this->getAdditional($nodeName));
                            }
                            $deleteNode = TRUE;
                            break;
                        case 'content':

                        case 'header':

                        case 'textblock':
                            $replaceNode = $dom->createTextNode($this->getElementData(FALSE));
                            $node->parentNode->insertBefore($replaceNode, $node);
                            $deleteNode = TRUE;
                            break;
                    }
                    break;
            }
            // Parse the child nodes of this node if available
            if ($node->hasChildNodes()) {
                $this->parseXML($dom, $node);
            }
            // Get the current node for deletion if replaced. We need this because nextSibling can be empty
            $oldNode = $node;
            // Go to next sibling to parse
            $node = $node->nextSibling;
            // Delete the old node. This can only be done after going to the next sibling
            if ($deleteNode) {
                $oldNode->parentNode->removeChild($oldNode);
            }
        }
    }
}