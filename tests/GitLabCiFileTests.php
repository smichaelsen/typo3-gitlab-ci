<?php
namespace Smichaelsen\Typo3GitlabCi\Tests;

use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class GitLabCiFileTests extends TestCase
{

    /**
     * @test
     */
    public function gitlabCiFileValid()
    {
        $client = new Client([
            'base_uri' => 'https://appzap.githost.io/api/v3/',
        ]);
        $data = json_encode([
            'content' => file_get_contents(__DIR__ . '/../src/gitlab-ci.yml'),
        ]);
        $response = $client->request('POST', 'ci/lint', [
            'body' => $data,
        ]);
        $responseBody = $response->getBody();
        $result = json_decode($responseBody, true);
        $this->assertEquals('valid', $result['status']);
    }

}
