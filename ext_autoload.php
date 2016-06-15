<?php
$extensionPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('pxa_form_enhancement');
return array(
    'TYPO3\CMS\Form\Domain\Model\Element\RecaptchaElement' => $extensionPath . 'Resources/Private/Php/FormEmptyClasses/RecaptchaElement.php',
    'TYPO3\CMS\Form\Validation\RecaptchaValidator' => $extensionPath . 'Resources/Private/Php/FormEmptyClasses/RecaptchaValidator.php',
    'TYPO3\CMS\Form\Domain\Model\Json\RecaptchaJsonElement' => $extensionPath . 'Resources/Private/Php/FormEmptyClasses/RecaptchaJsonElement.php',
    'TYPO3\CMS\Form\PostProcess\SaveFormPostProcessor' => $extensionPath . 'Resources/Private/Php/FormEmptyClasses/SaveFormPostProcessor.php'
);

?>