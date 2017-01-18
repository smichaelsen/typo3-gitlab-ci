# Gitlab CI configuration for your TYPO3 

This package can help you to set up GitLab CI and TYPO3. Your TYPO3 installation has to be composer based.

# Setup

Include the following configuration in your root composer.json:

    "require": {
    	"smichaelsen/typo3-gitlab-ci": "dev-master"
    },
    "extra": {
		"helhum/typo3-console": {
			"install-binary": false,
			"install-extension-dummy": false
		},
		"typo3/cms": {
			"cms-package-dir": "{$vendor-dir}/typo3/cms",
			"web-dir": "Web"
		}
	},
    "scripts": {
        "copy-gitlab-ci": [
            "cp vendor/smichaelsen/typo3-gitlab-ci/src/gitlab-ci.yml .gitlab-ci.yml"
        ],
        "post-autoload-dump": [
            "@copy-gitlab-ci"
        ]
    }

# GitLab variables

Set the following variables in your GitLab project to get a working deployment.

## SSH Connection

Generate an SSH key pair and store the private key in `SSH_PRIVATE_KEY`. Add the public key to `.ssh/authorized_keys` on
your target server(s).

Set `SSH_HOST` to the hostname (IP or domain) of your target server. Prepend it with the ssh username like this:
`username@hostname`. The deployment will be done to the `SSH_REMOTE_PATH`. Additionally provide a `$WEBROOT_FOLDER` path
as relative path from `SSH_REMOTE_PATH` to your web root (recommended: `Web/`).

`SSH_HOST` and `SSH_REMOTE_PATH` can be prefixed with a branch name, e.g. `master_SSH_HOST`
to make the setting valid for a certain branch.

## Database credentials

Set `DBNAME`, `DBUSER`, `DBPASS` and `DBHOST`.

You can prefix them with a branch name, e.g. `master_DBNAME` to make the setting valid for a certain branch.

## PHP binary

Set `PHP_BINARY` to the php binary path on the target server.

You can prefix it with a branch name, e.g. `master_PHP_BINARY` to make the setting valid for a certain branch.

## Encryption key

You can set your TYPO3 encryption key in `ENCRYPTION_KEY`.
If set it takes precedence over a `$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']` that might be set in your
`LocalConfiguration.php`.
 
You can prefix it with a branch name, e.g. `master_ENCRYPTION_KEY` to make the setting valid for a certain branch.

## Install Tool password

You can set your TYPO3 install tool password in `INSTALL_TOOL_PASSWORD`.
If set it takes precedence over a `$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']` that might be set in your
`LocalConfiguration.php`.
 
You can prefix it with a branch name, e.g. `master_INSTALL_TOOL_PASSWORD` to make the setting valid for a certain branch.

## fileadmin sync

If you want to sync the TYPO3 fileadmin directory between installations, set the `FILEADMIN_SYNC_SOURCE` to a certain
branch name, e.g. *master*. That will be the installation that the fileadmin is synced from.
