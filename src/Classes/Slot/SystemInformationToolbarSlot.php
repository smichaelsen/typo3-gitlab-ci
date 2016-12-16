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
        $gitReference = getenv('GIT_REFERENCE');
        if (!empty($gitReference)) {
            $systemInformationToolbarItem->addSystemInformation(
                'Git reference',
                substr($gitReference, 0, 8),
                '<i class="fa fa-git"></i>'
            );
        }
    }
}
