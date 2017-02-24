#!/bin/bash
[ -d gitlab-ci-scripts ] || mkdir gitlab-ci-scripts
cp vendor/smichaelsen/typo3-gitlab-ci/src/.gitlab-ci.yml.dist .gitlab-ci.yml
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/after-composer.sh gitlab-ci-scripts/_after-composer.sh
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/build-extensions.sh gitlab-ci-scripts/_build-extensions.sh
cp vendor/smichaelsen/typo3-gitlab-ci/scripts/pre-deploy.sh gitlab-ci-scripts/_pre-deploy.sh
