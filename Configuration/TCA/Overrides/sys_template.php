<?php
defined('TYPO3_MODE') or die();

// supporting TYPO3 v8 and v9
$majorTypo3Version = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionStringToArray(
    \TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()
)['version_main'];

switch ($majorTypo3Version) {
    case 8:
        $templatePathPostfix = '/Typo3v8Compatibility';
        break;
    case 9:
        $templatePathPostfix = '/Typo3v9Compatibility';
        break;
    default:
        $templatePathPostfix = '';
        break;
}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile(
    'pxa_form_enhancement',
    'Configuration/TypoScript' . $templatePathPostfix,
    'Pxa Form Enhancement'
);
