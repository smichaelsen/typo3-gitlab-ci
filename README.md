# Gitlab CI configuration for your TYPO3
 
 [![Build Status](https://travis-ci.org/smichaelsen/typo3-gitlab-ci.svg?branch=master)](https://travis-ci.org/smichaelsen/typo3-gitlab-ci)

This package can help you to set up deployment of your TYPO3 installation with GitLab CI. Your TYPO3 installation has to be composer based.

![Screenshot](doc/overview.png?raw=true "Screenshot")

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
        "install-gitlab-ci": [
            "vendor/smichaelsen/typo3-gitlab-ci/scripts/install.sh"
        ],
        "post-autoload-dump": [
            "@install-gitlab-ci"
        ]
    }

# GitLab variables

Set the following variables in your GitLab project to get a working deployment.

| Variable Name           | prefixable with branch name :star: | Description                                                                                                                                                                                                                                   | Mandatory          |
|-------------------------|------------------------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|--------------------|
| `SSH_PRIVATE_KEY`       | :x:                                | Private SSH key :sparkles:                                                                                                                                                                                                                    | :white_check_mark: |
| `SSH_HOST`              | :white_check_mark:                 | Hostname (IP or domain) of target server. Prepend it with ssh username like this: `username@hostname`                                                                                                                                         | :white_check_mark: |
| `SSH_REMOTE_PATH`       | :white_check_mark:                 | Path where on the target server the project should be deployed.                                                                                                                                                                               | :white_check_mark: |
| `DBHOST`                | :white_check_mark:                 | Database host                                                                                                                                                                                                                                 | :white_check_mark: |
| `DBNAME`                | :white_check_mark:                 | Database name                                                                                                                                                                                                                                 | :white_check_mark: |
| `DBUSER`                | :white_check_mark:                 | Database user                                                                                                                                                                                                                                 | :white_check_mark: |
| `DBPASS`                | :white_check_mark:                 | Database password                                                                                                                                                                                                                             | :white_check_mark: |
| `ENCRYPTION_KEY`        | :white_check_mark:                 | Overwrites the `$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']`.                                                                                                                                                                         | :x:                |
| `INSTALL_TOOL_PASSWORD` | :white_check_mark:                 | Overwrites the `$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']`.                                                                                                                                                                    | :x:                |
| `IM_PATH`               | :white_check_mark:                 | Overwrites the `$GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path']`.                                                                                                                                                                               | :x:                |
| `PHP_BINARY`            | :white_check_mark:                 | PHP binary that should be used to execute PHP cli scripts on the target server.                                                                                                                                                               | :x:                |
| `FILEADMIN_SYNC_SOURCE` | :white_check_mark:                 | Set to a certain branch name (e.g. `production`) from which you want to sync the fileadmin folder. E.g. `master_FILEADMIN_SYNC_SOURCE=production` will result in the fileadmin from `production` being synced to `master` on each deployment. | :x:                |


:star: Prefixing a variable name with a certain branch name will make the setting valid only for this branch. E.g. `master_DBPASS`
will only be valid for the `master` branch and will then take precedence over `DBPASS` if that is configured.
  
:sparkles: Generate an SSH key pair and store the private key in `SSH_PRIVATE_KEY`. Add the public key to `.ssh/authorized_keys` on your target server(s). Additionally add the public key as "Deploy Key" to private repositories that you need to load (e.g. via composer).

## Custom Scripts

You can invoke your own scripts at certain points of the deployment process. After installing this package you will find
a folder `gitlab-script/` in your root directory with script files prefixes with an underscore `_`. Remove the
underscore to activate the file and fill it with your own commands.

### `build-extensions.sh`

Will be executed in the `build_extensions` job. If your TYPO3 extensions need to be built before the deployment, you
can do it here. This job is executed with the [node:6](https://hub.docker.com/_/node/) docker image, which means the
machine is well prepared for node based frontend buildings (npm, grunt etc). But your script can also install other
software you need.

### `pre-deploy.sh`

Will be executed in the `deploy` job, right before the code is actually transfered to the target server. Use this script
to do last minute preparations on the target server.

Hint: In your own scripts you have all your Gitlab CI variables available. So you can perform commands on the target
server like this:

    ssh $SSH_HOST "echo 'Hello from the target server!'"
