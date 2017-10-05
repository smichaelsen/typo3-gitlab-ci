# Gitlab CI configuration for your TYPO3
 
 [![Build Status](https://travis-ci.org/smichaelsen/typo3-gitlab-ci.svg?branch=master)](https://travis-ci.org/smichaelsen/typo3-gitlab-ci)

This package can help you to set up deployment of your TYPO3 installation with GitLab CI. Your TYPO3 installation has to be composer based.

![Screenshot](doc/overview.png?raw=true "Screenshot")

# Setup

Include the following configuration in your root composer.json:

    "require": {
        "smichaelsen/typo3-gitlab-ci": "^4.0.0"
    },
    "extra": {
        "helhum/typo3-console": {
            "install-binary": false,
            "install-extension-dummy": false
        },
        "typo3/cms": {
            "cms-package-dir": "{$vendor-dir}/typo3/cms",
            "web-dir": "web"
        }
    },
    "scripts": {
        "install-gitlab-ci": [
            "{$vendor-dir}/smichaelsen/typo3-gitlab-ci/scripts/install.sh"
        ],
        "post-autoload-dump": [
            "@install-gitlab-ci"
        ]
    }

# GitLab variables

Set the following variables in your GitLab project to get a working deployment.

| Variable Name           | prefixable with branch name :star: | Description                                                                     | Mandatory          |
|-------------------------|------------------------------------|---------------------------------------------------------------------------------|--------------------|
| `SSH_PRIVATE_KEY`       | :x:                                | Private SSH key :sparkles:                                                      | :white_check_mark: |
| `SSH_USERNAME`          | :white_check_mark:                 | User name for SSH connection                                                    | :white_check_mark: |
| `SSH_HOST`              | :white_check_mark:                 | Hostname (IP or domain) of target server.                                       | :white_check_mark: |
| `SSH_REMOTE_PATH`       | :white_check_mark:                 | Path where on the target server the project should be deployed.                 | :white_check_mark: |
| `DBHOST`                | :white_check_mark:                 | Database host                                                                   | :white_check_mark: |
| `DBNAME`                | :white_check_mark:                 | Database name                                                                   | :white_check_mark: |
| `DBUSER`                | :white_check_mark:                 | Database user                                                                   | :white_check_mark: |
| `DBPASS`                | :white_check_mark:                 | Database password                                                               | :white_check_mark: |
| `ENCRYPTION_KEY`        | :white_check_mark:                 | Overwrites the `$GLOBALS['TYPO3_CONF_VARS']['SYS']['encryptionKey']`.           | :x:                |
| `INSTALL_TOOL_PASSWORD` | :white_check_mark:                 | Overwrites the `$GLOBALS['TYPO3_CONF_VARS']['BE']['installToolPassword']`.      | :x:                |
| `IM_PATH`               | :white_check_mark:                 | Overwrites the `$GLOBALS['TYPO3_CONF_VARS']['GFX']['im_path']`.                 | :x:                |
| `PHP_BINARY`            | :white_check_mark:                 | PHP binary that should be used to execute PHP cli scripts on the target server. | :x:                |

:star: Prefixing a variable name with a certain branch name will make the setting valid only for this branch. E.g. `master_DBPASS`
will only be valid for the `master` branch and will then take precedence over `DBPASS` if that is configured.
  
:sparkles: Generate an SSH key pair and store the private key in `SSH_PRIVATE_KEY`. Add the public key to `.ssh/authorized_keys` on your target server(s). Additionally add the public key as "Deploy Key" to private repositories that you need to load (e.g. via composer).

## Custom Scripts and configuration

You can invoke your own scripts at certain points of the deployment process. After installing this package you will find
a folder `gitlab-script/` in your root directory with files prefixed with an underscore `_`. Remove the
underscore to activate the file and fill it with your own commands.

### `after-composer.sh`

Will be executed in the `composer` job which loads all dependencies and then moves everything to the `.Build` folder
that is needed in the next stages and will eventually be deployed. You can use this custom script to influence the
contents of `.Build`.

### `build-extensions.sh`

Will be executed in the `build_extensions` job. If your TYPO3 extensions need to be built before the deployment, you
can do it here. This job is executed with the [node:8](https://hub.docker.com/_/node/) docker image, which means the
machine is well prepared for node based frontend buildings (npm, grunt etc). But your script can also install other
software you need.

### `pre-deploy.sh`

Will be executed in the `deploy` job, right before the code is actually transfered to the target server. Use this script
to do last minute preparations on the target server.

Hint: In your own scripts you have all your Gitlab CI variables available. So you can perform commands on the target
server like this:

    ssh $SSH_USERNAME@$SSH_HOST "echo 'Hello from the target server!'"
    
### `rsync-build-excludes.txt`

List files and directories in here that you want to exclude from your whole CI process. This speeds up your CI process
and lowers disk usage on the runner server. List one file / directory pattern per line.

### `rsync-deploy-excludes.txt`

List files and directories in here that you used in the CI process but don't want to deploy onto the target server.
It's good practice and improves security to only ship to the production server what is really needed to run then website.
List one file / directory pattern per line.

## Versions and updating

This package uses [semantic versioning](http://semver.org/). So you are encouraged to require
the package with `^4.0.0`. Then you can expect receiving bugfix releases and improvements without breaking changes.  

### Breaking Changes:

#### 3.x to 4.x:

* [88a6e934](https://github.com/smichaelsen/typo3-gitlab-ci/commit/88a6e934d5256e0a76247734266abd42c5c3dabc): PHP is now required in version 7.0
* [1c8d9c70](https://github.com/smichaelsen/typo3-gitlab-ci/commit/1c8d9c70b73f15f014cc9d24552def230ecfb724): The web directory was renamed from `Web` to lowercase `web`. Be sure to set `"web-dir": "web"` in your `composer.json` (see above at "Setup"). Also be sure your web server host config points to the lower case directory. On case insensitive file systems (like macOS) you will have to rename your directory manually. 
* [dbdf3ba2](https://github.com/smichaelsen/typo3-gitlab-ci/commit/dbdf3ba200d94034c4b8aa4c061a6754ac3ac639): The `build_extensions` job is now executed with a node 8 image instead of node 7. Make sure your frontend building works based on node 8.

#### 2.x to 3.x:

* [384242e0](https://github.com/smichaelsen/typo3-gitlab-ci/commit/384242e0d426a653b4e5e6d8ae6aa6d6cc2a0e64): The `.Build` folder is now built from all files excluding some certain files and directories (such as `.git`) instead of only copying a list of known files and directory. That can result in additional files landing in the `.Build` folder and being deploying eventually. Use the new `gitlab-ci-scripts/rsync-build-excludes.txt` to define additional excludes. 
* [a6a12ee3](https://github.com/smichaelsen/typo3-gitlab-ci/commit/a6a12ee3278e6da42b83b023f439fa51ed8645f6): The fileadmin sync feature was removed as it was complex to setup and buggy. The pipeline runs faster now without the unnecessary stage.
* [ff869f95](https://github.com/smichaelsen/typo3-gitlab-ci/commit/ff869f9552ebdf281f32eaaa402ce9f3575846f9): The [TYPO3 console](https://github.com/TYPO3-Console/TYPO3-Console) now additonally executes `extension:setupactive` and `upgrade:all`. Please check if that is desired for your project.
* [055f641c](https://github.com/smichaelsen/typo3-gitlab-ci/commit/055f641c5d15226149dc8334a674a653ee66f7ea): `download` and `typo3conf/LFEditor` are not excluded from deployment anymore, because they are very project specific. If you rely on them not being rsynced, add them to `gitlab-ci-scripts/rsync-deploy-excludes.txt`
* [cf5cc8b0](https://github.com/smichaelsen/typo3-gitlab-ci/commit/cf5cc8b0a7c5c705f1fafe1a71f5f8af6475d0d1): The `build_extensions` job is now executed with a node 7 image instead of node 6. Make sure your frontend building works based on node 7. 

#### 1.x to 2.x:

* Instead of providing *both* ssh user name *and* host in `SSH_HOST`, now there is a separate `SSH_USERNAME` variable. You have to set it to make sure your deployment works.
