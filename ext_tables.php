<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Pxa Form Enhancement');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_pxaformenhancement_domain_model_form', 'EXT:pxa_form_enhancement/Resources/Private/Language/locallang_csh_tx_pxaformenhancement_domain_model_form.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_pxaformenhancement_domain_model_form');
