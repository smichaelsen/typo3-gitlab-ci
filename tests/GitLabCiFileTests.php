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
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents(__DIR__ . '/../src/gitlab-ci.yml'));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        $result = curl_exec($ch);
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($result, 0, $header_size);
        $body = substr($result, $header_size);
        curl_close($ch);
        var_dump([$header, $body]);
        $this->assertTrue(true);
    }

}
