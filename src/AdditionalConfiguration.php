<?php

if (isset($GLOBALS['TYPO3_CONF_VARS']['EXT']['dotenvPath'])) {
    $dotenvPath = PATH_site . $GLOBALS['TYPO3_CONF_VARS']['EXT']['dotenvPath'];
} else {
    $dotenvPath = __DIR__ . '/../..';
}

$dotenv = new Dotenv\Dotenv($dotenvPath);
$dotenv->load();

$dotenv->required([
    'DBNAME',
    'DBPASS',
    'DBUSER',
    'DBHOST',
    'ENVNAME',
]);

$credentials = [
    'database' => getenv('DBNAME'),
    'password' => getenv('DBPASS'),
    'username' => getenv('DBUSER'),
    'host' => getenv('DBHOST'),
];

if ((int) TYPO3_branch[0] === 7) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['database'] = getenv('DBNAME');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['password'] = getenv('DBPASS');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['username'] = getenv('DBUSER');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['host'] = getenv('DBHOST');
} else {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = getenv('DBNAME');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = getenv('DBPASS');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = getenv('DBUSER');
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = getenv('DBHOST');
}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = str_replace(
    '[LIVE]',
    '[' . getenv('ENVNAME') . ']',
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']
);

\TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class)->connect(
    \TYPO3\CMS\Backend\Backend\ToolbarItems\SystemInformationToolbarItem::class,
    'getSystemInformation',
    \Smichaelsen\Typo3GitlabCi\Slot\SystemInformationToolbarSlot::class,
    'addItems'
);
