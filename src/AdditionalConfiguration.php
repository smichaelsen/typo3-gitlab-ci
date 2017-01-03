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
    $dbConfig = [
        'database' => getenv('DBNAME'),
        'password' => getenv('DBPASS'),
        'username' => getenv('DBUSER'),
        'host' => getenv('DBHOST'),
    ];
} else {
    $dbConfig = [
        'Connections' => [
            'Default' => [
                'dbname' => getenv('DBNAME'),
                'password' => getenv('DBPASS'),
                'user' => getenv('DBUSER'),
                'host' => getenv('DBHOST'),
            ],
        ],
    ];
}
$GLOBALS['TYPO3_CONF_VARS'] = array_merge_recursive(
    $GLOBALS['TYPO3_CONF_VARS'],
    ['DB' => $dbConfig]
);

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
