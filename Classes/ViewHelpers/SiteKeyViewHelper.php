<?php
declare(strict_types=1);

namespace Pixelant\PxaFormEnhancement\ViewHelpers;

use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class SiteKeyViewHelper extends AbstractViewHelper
{
    protected ConfigurationManagerInterface $configurationManager;

    public function __construct(ConfigurationManagerInterface $configurationManager)
    {
        $this->configurationManager = $configurationManager;
    }

    public function render(): ?string
    {
        $settings = $this->configurationManager->getConfiguration(
            ConfigurationManagerInterface::CONFIGURATION_TYPE_SETTINGS,
            'pxaformenhancement'
        );

        return $settings['siteKey'] ?? null;
    }
}
