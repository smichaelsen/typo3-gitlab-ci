# Gitlab CI configuration for your TYPO3 

This package can help you to set up GitLab CI and TYPO3. Your TYPO3 installation has to be composer based.

# Setup

Include the following scripts in your root composer.json:

    "scripts": {
        "post-install-cmd": [
            "cp vendor/smichaelsen/typo3-gitlab-ci/src/gitlab-ci.yml .gitlab-ci.yml"
        ],
        "post-update-cmd": [
            "cp vendor/smichaelsen/typo3-gitlab-ci/src/gitlab-ci.yml .gitlab-ci.yml"
        ]
    },
