<?php

namespace Smichaelsen\Typo3GitlabCi;

use Smichaelsen\Typo3GitlabCi\Slot\SystemInformationToolbarSlot;
use TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\SignalSlot\Dispatcher;

class ConfigLoader
{

    public function populate()
    {
        $this->loadDatabaseCredentials();
        $this->loadAdditionalConfigurationValues();
        $this->registerSlots();
    }

    protected function loadDatabaseCredentials()
    {
        $defaultDbConfig = [];

        $dbname = getenv('DBNAME');
        if (!empty($dbname)) {
            $defaultDbConfig['database'] = $dbname;
        }

        $dbhost = getenv('DBHOST');
        if (!empty($dbname)) {
            $defaultDbConfig['host'] = $dbhost;
        }

        $dbpass = getenv('DBPASS');
        if (!empty($dbpass)) {
            $defaultDbConfig['password'] = $dbpass;
        }

        $dbuser = getenv('DBUSER');
        if (!empty($dbuser)) {
            $defaultDbConfig['username'] = $dbuser;
        }

        $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'] = array_replace_recursive(
            $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections'],
            ['Default' => $defaultDbConfig]
        );
    }

    protected function loadAdditionalConfigurationValues()
    {
        if (!empty(getenv('ENCRYPTION_KEY'))) {
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey'] = getenv('ENCRYPTION_KEY');
        }

        if (!empty(getenv('INSTALL_TOOL_PASSWORD'))) {
            $GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword'] = md5(getenv('INSTALL_TOOL_PASSWORD'));
        }

        if (!empty(getenv('IM_PATH'))) {
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path'] = getenv('IM_PATH');
            $GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path_lzw'] = getenv('IM_PATH');
        }

        $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = sprintf(
            '[%s] %s',
            getenv('ENVNAME'),
            $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']
        );
    }

    protected function registerSlots()
    {
        GeneralUtility::makeInstance(Dispatcher::class)->connect(
            SystemInformationToolbarItem::class,
            'getSystemInformation',
            SystemInformationToolbarSlot::class,
            'addItems'
        );
    }
}
