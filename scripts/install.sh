#!/bin/bash
[ -d gitlab-ci-scripts ] || mkdir gitlab-ci-scripts
if [ ! -f web/typo3conf/AdditionalConfiguration.php ]; then
    cp vendor/smichaelsen/typo3-gitlab-ci/src/AdditionalConfiguration.php web/typo3conf/
fi
if [ ! -f .env ]; then
    cp vendor/smichaelsen/typo3-gitlab-ci/src/.env-example .env
fi
cp vendor/smichaelsen/typo3-gitlab-ci/src/.gitlab-ci.yml.dist .gitlab-ci.yml
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/after-composer.sh gitlab-ci-scripts/_after-composer.sh
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/build-extensions.sh gitlab-ci-scripts/_build-extensions.sh
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/pre-deploy.sh gitlab-ci-scripts/_pre-deploy.sh
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/rsync-build-excludes.txt gitlab-ci-scripts/_rsync-build-excludes.txt
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/rsync-deploy-excludes.txt gitlab-ci-scripts/_rsync-deploy-excludes.txt
