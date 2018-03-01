<?php
namespace Smichaelsen\Typo3GitlabCi\Slot;

use TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem;
use TYPO3\CMS\Core\Imaging\Icon;
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class SystemInformationToolbarSlot
{

    /**
     * @param SystemInformationToolbarItem $systemInformationToolbarItem
     */
    public function addItems(SystemInformationToolbarItem $systemInformationToolbarItem)
    {
        $gitReference = getenv('GIT_REFERENCE');
        $iconIdentifier = 'sysinfo-git';

        if (!empty($gitReference)) {
            $systemInformationToolbarItem->addSystemInformation(
                'Git reference',
                substr($gitReference, 0, 8),
                $iconIdentifier
            );
        }
    }
}
