<?php

namespace NextDeveloper\Vinchin\Services;

use NextDeveloper\Vinchin\Exceptions\Http422UnprocessableEntity;
use NextDeveloper\Vinchin\Exceptions\HttpException;
use NextDeveloper\Vinchin\Requests\VirtualizationParameters;

class Logs extends AbstractService
{
    private const ENDPOINT_SYSTEM = '/logs/systems';
    private const ENDPOINT_JOB = '/logs/jobs';

    public function __construct($client)
    {
        parent::__construct($client);
    }

    /**
     * Retrieves system logs.
     *
     * @param array $parameters The query parameters.
     * @return array The response data.
     * @throws HttpException
     */
    public function getSystemLogs(array $parameters = ['begin' => 0, 'count' => 10])
    {
        $endpoint = self::ENDPOINT_SYSTEM . '/lists';
        return $this->client->get($endpoint, $parameters);
    }

    /**
     * Deletes system log(s).
     *
     * @param array $data The data containing log ID(s).
     * @return array The response data.
     * @throws Http422UnprocessableEntity|HttpException If the required parameters are missing or invalid.
     */
    public function deleteSystemLog(array $data)
    {
        VirtualizationParameters::validateParameters($data, ['id']);
        VirtualizationParameters::validateArray($data['id'], 'id');

        $endpoint = self::ENDPOINT_SYSTEM;
        return $this->client->delete($endpoint, $data);
    }

    /**
     * Retrieves job logs.
     *
     * @param array $parameters The query parameters.
     * @return array The response data.
     * @throws HttpException
     */
    public function getJobLogs(array $parameters = ['begin' => 0, 'count' => 10])
    {
        $endpoint = self::ENDPOINT_JOB . '/lists';
        return $this->client->get($endpoint, $parameters);
    }

    /**
     * Deletes job log(s).
     *
     * @param array $data The data containing log ID(s).
     * @return array The response data.
     * @throws Http422UnprocessableEntity|HttpException If the required parameters are missing or invalid.
     */
    public function deleteJobLog(array $data)
    {
        VirtualizationParameters::validateParameters($data, ['id']);
        VirtualizationParameters::validateArray($data['id'], 'id');

        $endpoint = self::ENDPOINT_JOB;
        return $this->client->delete($endpoint, $data);
    }
}
