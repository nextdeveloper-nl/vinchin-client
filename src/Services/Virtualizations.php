<?php

namespace NextDeveloper\Vinchin\Services;

use NextDeveloper\Vinchin\Requests\VirtualizationParameters;

class Virtualizations extends AbstractService implements ServiceInterface
{
    private const ENDPOINT = '/vcenters';

    public function __construct($client)
    {
        parent::__construct($client);
    }

    /**
     * Retrieves a list of virtualizations.
     *
     * @param array $parameters Optional parameters for pagination.
     * @return array The list of virtualizations.
     * @throws \Exception If an error occurs during the request.
     */
    public function get(array $parameters = ['begin' => 0, 'count' => 10])
    {
        $endpoint = self::ENDPOINT . '/lists';
        $response = $this->client->get($endpoint, $parameters);
        return $response;
    }

    /**
     * Creates a new virtualization.
     *
     * @param array $data Data for creating the virtualization, including 'hypervisor', 'vcenter_ip', 'user_name', 'password', and 'alias'.
     * @return array The created virtualization.
     * @throws \Exception If required parameters are missing or if an error occurs during the request.
     */
    public function create(array $data)
    {
        $requiredParams = ['hypervisor', 'vcenter_ip', 'user_name', 'password', 'alias'];

        VirtualizationParameters::validateParameters($data, $requiredParams);

        $endpoint = self::ENDPOINT;
        $response = $this->client->post($endpoint, $data);
        return $response;
    }

    /**
     * Updates an existing virtualization.
     *
     * @param array $data Data for updating the virtualization, including 'hypervisor', 'vcenter_ip', 'user_name', 'password', 'alias', and 'vcenter_uuid'.
     * @return array The updated virtualization.
     * @throws \Exception If required parameters are missing or if an error occurs during the request.
     */
    public function update(array $data)
    {
        $requiredParams = ['hypervisor', 'vcenter_ip', 'user_name', 'password', 'alias', 'vcenter_uuid'];
        VirtualizationParameters::validateParameters($data, $requiredParams);

        $endpoint = self::ENDPOINT;
        $response = $this->client->put($endpoint, $data);
        return $response;
    }

    /**
     * Deletes a virtualization.
     *
     * @param array $data Data for deleting the virtualization, including 'hypervisor' and 'vcenter_uuid'.
     * @return array The response from the server after deletion.
     * @throws \Exception If required parameters are missing or if an error occurs during the request.
     */
    public function delete(array $data)
    {
        $requiredParams = ['hypervisor', 'vcenter_uuid'];
        VirtualizationParameters::validateParameters($data, $requiredParams);

        $endpoint = self::ENDPOINT;
        $response = $this->client->delete($endpoint, $data);
        return $response;
    }

}
