<?php
defined('TYPO3_MODE') or die();

call_user_func(
    function ($_EXTKEY) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr(
            'tx_pxaformenhancement_domain_model_form',
            'EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_csh_tx_pxaformenhancement_domain_model_form.xlf'
        );
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages(
            'tx_pxaformenhancement_domain_model_form'
        );

        if (TYPO3_MODE === 'BE') {
            /** @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry */
            $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(
                \TYPO3\CMS\Core\Imaging\IconRegistry::class
            );

            $icons = [
                'ext-pxaformenhancement-finisher-icon' => 'save.svg',
                'ext-pxaformenhancement-letter-icon' => 'letter.svg',
                'ext-pxaformenhancement-recaptcha-icon' => 'recaptcha.svg'
            ];

            foreach ($icons as $key => $icon) {
                $iconRegistry->registerIcon(
                    $key,
                    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                    ['source' => 'EXT:pxa_form_enhancement/Resources/Public/Icons/' . $icon]
                );
            }
        }
    },
    'pxa_form_enhancement'
);
