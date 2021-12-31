<?php
declare(strict_types=1);

$ll = 'LLL:EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf:';
$llImagePalette = 'LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette';

return [
    'ctrl' => [
        'title' => $ll . 'tx_pxaformenhancement_domain_model_form',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'cruser_id' => 'cruser_id',
        'dividers2tabs' => true,
        'default_sortby' => 'crdate DESC',

        'delete' => 'deleted',

        'searchFields' => 'name,form_data',
        'typeicon_classes' => [
            'default' => 'ext-pxaformenhancement-letter-icon'
        ]
    ],
    'interface' => [
        'showRecordFieldList' => 'hidden, name, attachments, form_data',
    ],
    'types' => [
        '1' => [
            'showitem' => 'name, attachments, form_data'
        ],
    ],
    'palettes' => [
        '1' => ['showitem' => ''],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => 1,
            'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
                'default' => '0'
            ],
        ],
        'name' => [
            'exclude' => 1,
            'label' => $ll . 'tx_pxaformenhancement_domain_model_form.name',
            'config' => [
                'type' => 'input',
                'eval' => 'trim,required'
            ]
        ],
        'attachments' => [
            'exclude' => 1,
            'label' => $ll . 'tx_pxaformenhancement_domain_model_form.attachments',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'attachments',
                [
                    'appearance' => [
                        'createNewRelationLinkTitle' =>
                            'LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:images.addFileReference',
                        'enabledControls' => [
                            'info' => true,
                            'new' => false,
                            'dragdrop' => true,
                            'sort' => false,
                            'hide' => true,
                            'delete' => false,
                            'localize' => false,
                        ]
                    ],
                    'overrideChildTca' => [
                        'types' => [
                            '0' => [
                                'showitem' => '
                                --palette--;' . $llImagePalette . '
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
                                'showitem' => '
                                --palette--;' . $llImagePalette . '
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
                                'showitem' => '
                                --palette--;' . $llImagePalette . '
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
                                'showitem' => '
                                --palette--;' . $llImagePalette . '
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
                                'showitem' => '
                                --palette--;' . $llImagePalette . '
                                --palette--;;filePalette'
                            ],
                            \TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
                                'showitem' => '
                                --palette--;' . $llImagePalette . '
                                --palette--;;filePalette'
                            ]
                        ]
                    ],
                    'maxitems' => 99
                ]
            ),
        ],
        'form_data' => [
            'exclude' => 1,
            'label' => $ll . 'tx_pxaformenhancement_domain_model_form.form_data',
            'config' => [
                'type' => 'text',
                'cols' => 40,
                'rows' => 15,
                'eval' => 'trim'
            ]
        ]
    ]
];
