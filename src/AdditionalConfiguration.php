<?php

$environmentConfiguration = parse_ini_file(__DIR__ . '/../../files/environmentConfiguration.txt');

$GLOBALS['TYPO3_CONF_VARS']['DB']['database'] = $environmentConfiguration['DBNAME'];
$GLOBALS['TYPO3_CONF_VARS']['DB']['password'] = $environmentConfiguration['DBPASS'];
$GLOBALS['TYPO3_CONF_VARS']['DB']['username'] = $environmentConfiguration['DBUSER'];
$GLOBALS['TYPO3_CONF_VARS']['DB']['host'] = $environmentConfiguration['DBHOST'];

$GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename'] = str_replace('[LIVE]', '[' . $environmentConfiguration['ENVNAME'] . ']', $GLOBALS['TYPO3_CONF_VARS']['SYS']['sitename']);

unset ($environmentConfiguration);
