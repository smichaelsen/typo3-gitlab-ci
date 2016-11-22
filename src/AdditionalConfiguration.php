<?php

$environmentConfiguration = parse_ini_file(__DIR__ . '/../../files/environmentConfiguration.txt');

$credentials = [
    'database' => $environmentConfiguration['DBNAME'],
    'password' => $environmentConfiguration['DBPASS'],
    'username' => $environmentConfiguration['DBUSER'],
    'host' => $environmentConfiguration['DBHOST'],
];

if ((int)TYPO3_branch[0] === 7) {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['database'] = $environmentConfiguration['DBNAME'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['password'] = $environmentConfiguration['DBPASS'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['username'] = $environmentConfiguration['DBUSER'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['host'] = $environmentConfiguration['DBHOST'];
} else {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['dbname'] = $environmentConfiguration['DBNAME'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['password'] = $environmentConfiguration['DBPASS'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['user'] = $environmentConfiguration['DBUSER'];
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default']['host'] = $environmentConfiguration['DBHOST'];
}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = str_replace('[LIVE]', '[' . $environmentConfiguration['ENVNAME'] . ']', $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']);

unset ($environmentConfiguration);
