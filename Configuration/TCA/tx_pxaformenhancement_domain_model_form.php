<?php
return [
	'ctrl' => [
		'title'	=> 'LLL:EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf:tx_pxaformenhancement_domain_model_form',
		'label' => 'name',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
        'default_sortby' => 'crdate DESC',
        
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'name,attachment,form_data,',
		'iconfile' => 'EXT:pxa_form_enhancement/Resources/Public/Icons/tx_pxaformenhancement_domain_model_form.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'hidden, name, attachment, form_data',
	],
	'types' => [
		'1' => ['showitem' => 'hidden, --palette--;;1, name, attachment, form_data, 
		        --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access,
			    --palette--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:palette.access, starttime, endtime']
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
			],
		],
		'starttime' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
			],
		],
		'endtime' => [
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => [
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				],
			],
		],

		'name' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf:tx_pxaformenhancement_domain_model_form.name',
			'config' => [
				'type' => 'input',
				'eval' => 'trim,required'
			]
		],
		'attachment' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf:tx_pxaformenhancement_domain_model_form.attachment',
			'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
				'attachment',
				[
					'appearance' => [
						'createNewRelationLinkTitle' => 'LLL:EXT:cms/locallang_ttc.xlf:media.addFileReference',
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
					'foreign_types' => [
						'0' => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_TEXT => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_IMAGE => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_AUDIO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_VIDEO => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						],
						\TYPO3\CMS\Core\Resource\File::FILETYPE_APPLICATION => [
							'showitem' => '
							--palette--;LLL:EXT:lang/locallang_tca.xlf:sys_file_reference.imageoverlayPalette;imageoverlayPalette,
							--palette--;;filePalette'
						]
					],
					'maxitems' => 1
                ]
            ),
		],
		'form_data' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:pxa_form_enhancement/Resources/Private/Language/locallang_db.xlf:tx_pxaformenhancement_domain_model_form.form_data',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		]
	]
];## EXTENSION BUILDER DEFAULTS END TOKEN - Everything BEFORE this line is overwritten with the defaults of the extension builder