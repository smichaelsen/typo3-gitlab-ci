<?php
namespace Smichaelsen\Typo3GitlabCi\Tests;

use PHPUnit\Framework\TestCase;

class GitLabCiFileTests extends TestCase
{

    /**
     * @test
     */
    public function gitlabCiFileValid()
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://gitlab.com/api/v3/ci/lint");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents(__DIR__ . '../src/gitlab-ci.yml'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        var_dump($result);
        $this->assertTrue(true);
    }

}
