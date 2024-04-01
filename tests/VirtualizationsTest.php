<?php

namespace Tests\tests;

use NextDeveloper\Vinchin\Clients\AccessToken;
use NextDeveloper\Vinchin\Clients\CurlClient;
use NextDeveloper\Vinchin\Types\AvailableVirtualizationType;
use NextDeveloper\Vinchin\Services\Virtualizations;
use Tests\TestCase;

class VirtualizationsTest extends TestCase
{
    private const USERNAME = 'admin';
    private const PASSWORD = '123456';
    private const BASE_URL = 'https://10.128.0.8:8080/api';

    private string $accessToken;

    /**
     * @throws \Exception
     */
    protected function setUp(): void
    {
        parent::setUp();

        $accessToken = new AccessToken();
        $this->accessToken = $accessToken->get(self::USERNAME, self::PASSWORD);
    }

    /**
     * @throws \Exception
     */
    public function test_get_access_token()
    {
        $this->assertNotEmpty($this->accessToken, 'Failed to obtain access token.');
    }

    /**
     * @throws \Exception
     */
    public function test_get_virtualizations()
    {
        $virtualizations = new Virtualizations(new CurlClient(self::BASE_URL, $this->accessToken));
        $response = $virtualizations->get();

        $this->assertIsArray($response);

        $this->isTrue($response['success']);
        $this->assertArrayHasKey('data', $response);

    }

    /**
     * @dataProvider virtualizationData
     * @throws \Exception
     */
    public function test_create_virtualization($hypervisor, $vcenterIp, $userName, $password, $alias, $detail)
    {
        $virtualizations = new Virtualizations(new CurlClient(self::BASE_URL, $this->accessToken));

        $data = [
            'hypervisor'    => $hypervisor,
            'vcenter_ip'    => $vcenterIp,
            'user_name'     => $userName,
            'password'      => $password,
            'alias'         => $alias,
        ];

        $response = $virtualizations->create($data);

        $this->isTrue($response['success']);
        $this->assertArrayHasKey('data', $response);
        $this->assertArrayHasKey('vcenter_uuid', $response['data']);
    }

    public function virtualizationData(): array
    {
        return [
            [
                AvailableVirtualizationType::MICROSOFT_HYPER_V->value,
                '10.128.0.8',
                'admin',
                '123456',
                '10.128.0.8',
                ['type' => 2],
            ],
        ];
    }

    /**
     * @dataProvider virtualizationData
     * @throws \Exception
     */
    public function test_update_virtualization($hypervisor, $vcenterIp, $userName, $password, $alias, $detail)
    {
        $virtualizations = new Virtualizations(new CurlClient(self::BASE_URL, $this->accessToken));

        $data = [
            'hypervisor'        => $hypervisor,
            'vcenter_ip'        => $vcenterIp,
            'user_name'         => $userName,
            'password'          => $password,
            'alias'             => $alias,
            'vcenter_uuid'      => '123456',
        ];

        $response = $virtualizations->update($data);

        $this->assertNotEmpty($response, 'Failed to update virtualization.');
    }

    /**
     * @throws \Exception
     */
    public function test_delete_virtualization()
    {
        $virtualizations = new Virtualizations(new CurlClient(self::BASE_URL, $this->accessToken));

        $data = [
            'hypervisor' => AvailableVirtualizationType::INCLOUD_SPHERE_XEN->value,
            'vcenter_uuid' => 'uomv-3d4f-4b4f-8f4f-4b4f4b4f4b4f',
        ];

        $response = $virtualizations->delete($data);

        $this->assertNotEmpty($response, 'Failed to delete virtualization.');
    }
}
