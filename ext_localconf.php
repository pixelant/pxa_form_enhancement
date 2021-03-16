<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(function () {
    // Scheduler clean up of saved forms
    $garbageTask = \TYPO3\CMS\Scheduler\Task\TableGarbageCollectionTask::class;
    $table = 'tx_pxaformenhancement_domain_model_form';
    if (!is_array($GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table])) {
        $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['scheduler']['tasks'][$garbageTask]['options']['tables'][$table] = [
            'dateField' => 'crdate',
            'expirePeriod' => 30,
        ];
    }

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
module.tx_form {
    settings {
        yamlConfigurations {
            510 = EXT:pxa_form_enhancement/Configuration/Yaml/PxaBaseSetup.yaml
            520 = EXT:pxa_form_enhancement/Configuration/Yaml/PxaFormEditor.yaml
            530 = EXT:pxa_form_enhancement/Configuration/Yaml/PxaFormEngine.yaml
        }
    }
}'
    ));

    // supporting TYPO3 v8 and v9
    $typoVersionArray = \TYPO3\CMS\Core\Utility\VersionNumberUtility::convertVersionStringToArray(
        \TYPO3\CMS\Core\Utility\VersionNumberUtility::getNumericTypo3Version()
    );

    if (in_array($typoVersionArray['version_main'], [8, 9])) {
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(trim('
config.tx_extbase {
    persistence {
        classes {
            Pixelant\PxaFormEnhancement\Domain\Model\FileReference {
                mapping {
                    tableName = sys_file_reference
                }
            }
        }
    }
}'
        ));
    }
});
