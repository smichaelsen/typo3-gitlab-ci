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
        curl_setopt($ch, CURLOPT_URL, "https://appzap.githost.io/api/v3/ci/lint");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents(__DIR__ . '/../src/gitlab-ci.yml'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $result = json_decode(curl_exec($ch), true);
        curl_close($ch);
        $this->assertEquals('valid', $result['status']);
    }

}
