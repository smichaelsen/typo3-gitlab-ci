<?php
namespace Smichaelsen\Typo3GitlabCi\Slot;

use TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem;

class SystemInformationToolbarSlot
{

    /**
     * @param SystemInformationToolbarItem $systemInformationToolbarItem
     */
    public function addItems(SystemInformationToolbarItem $systemInformationToolbarItem)
    {
        $environmentConfigurationFile = PATH_site . '/../files/environmentConfiguration.txt';
        if (is_readable($environmentConfigurationFile)) {
            $environmentConfiguration = parse_ini_file($environmentConfigurationFile);
            if (!empty($environmentConfiguration['GIT_REFERENCE'])) {
                $systemInformationToolbarItem->addSystemInformation(
                    'Git reference',
                    substr($environmentConfiguration['GIT_REFERENCE'], 0, 8),
                    '<i class="fa fa-git"></i>'
                );
            }
        }
    }
}
