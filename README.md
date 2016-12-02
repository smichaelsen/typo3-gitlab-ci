# Gitlab CI configuration for your TYPO3 

This package can help you to set up GitLab CI and TYPO3. Your TYPO3 installation has to be composer based.

# Setup

Include the following configuration in your root composer.json:

    "extra": {
		"helhum/typo3-console": {
			"install-binary": false,
			"install-extension-dummy": false
		},
		"typo3/cms": {
			"cms-package-dir": "{$vendor-dir}/typo3/cms"
		}
	},
    "scripts": {
        "post-install-cmd": [
            "cp vendor/smichaelsen/typo3-gitlab-ci/src/gitlab-ci.yml .gitlab-ci.yml"
        ],
        "post-update-cmd": [
            "cp vendor/smichaelsen/typo3-gitlab-ci/src/gitlab-ci.yml .gitlab-ci.yml"
        ]
    }
