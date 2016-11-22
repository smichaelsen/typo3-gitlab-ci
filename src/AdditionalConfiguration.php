<?php

$environmentConfiguration = parse_ini_file(__DIR__ . '/../../files/environmentConfiguration.txt');

$credentials = [
    'database' => $environmentConfiguration['DBNAME'],
    'password' => $environmentConfiguration['DBPASS'],
    'username' => $environmentConfiguration['DBUSER'],
    'host' => $environmentConfiguration['DBHOST'],
];

if ((int)TYPO3_branch[0] === 7) {
    $GLOBALS['TYPO3_CONF_VARS']['DB'] = array_merge($GLOBALS['TYPO3_CONF_VARS']['DB'], $credentials);
} else {
    $GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'] = array_merge($GLOBALS['TYPO3_CONF_VARS']['DB']['Connections']['Default'], $credentials);
}

$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = str_replace('[LIVE]', '[' . $environmentConfiguration['ENVNAME'] . ']', $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']);

unset ($environmentConfiguration);
