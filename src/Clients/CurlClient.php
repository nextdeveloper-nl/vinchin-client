<?php

namespace NextDeveloper\Vinchin\Clients;


use NextDeveloper\Vinchin\Exceptions\HttpException;

class CurlClient
{
    protected string $baseUrl;
    protected string $accessToken;

    /**
     * CurlClient constructor.
     *
     * @param string $baseUrl The base URL for API requests.
     * @param string $accessToken The access token for authorization.
     */
    public function __construct(string $baseUrl, string $accessToken)
    {
        $this->baseUrl = $baseUrl;
        $this->accessToken = $accessToken;
    }

    /**
     * Make an HTTP request.
     *
     * @param string $method The HTTP method (GET, POST, PUT, DELETE).
     * @param string $endpoint The API endpoint.
     * @param mixed|null $data The request data.
     * @return mixed The response data.
     * @throws HttpException
     */
    public function request(string $method, string $endpoint, mixed $data = null, array $queryParams = [])
    {
        $url = $this->baseUrl . '/' . ltrim($endpoint, '/');

        if (!empty($queryParams)) {
            $url .= '?' . http_build_query($queryParams);
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/vnd.vinchin-v1+json;charset=utf-8',
                'Accept: application/vnd.vinchin-v1+json',
                'Authorization: ' . $this->accessToken,
            ],
        ]);

        if ($data !== null) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new HttpException(curl_error($ch), curl_errno($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new HttpException(
                'HTTP status code: ' . $statusCode . ' Response: ' . $response,
                $statusCode
            );
        }

        curl_close($ch);

        return json_decode($response, true);
    }

    /**
     * Make a GET request to the API.
     *
     * @param string $endpoint The API endpoint.
     * @param array $queryParams The query parameters.
     * @return mixed The response data.
     * @throws HttpException
     */
    public function get(string $endpoint, array $queryParams = [])
    {
        return $this->request('GET', $endpoint, null, $queryParams);
    }

    /**
     * Make a POST request to the API.
     *
     * @param string $endpoint The API endpoint.
     * @param mixed $data The request data.
     * @return mixed The response data.
     * @throws HttpException
     */
    public function post(string $endpoint, array $data)
    {
        return $this->request('POST', $endpoint, $data);
    }

    /**
     * Make a PUT request to the API.
     *
     * @param string $endpoint The API endpoint.
     * @param mixed $data The request data.
     * @return mixed The response data.
     * @throws HttpException
     */
    public function put(string $endpoint, array $data)
    {
        return $this->request('PUT', $endpoint, $data);
    }

    /**
     * Make a DELETE request to the API.
     *
     * @param string $endpoint The API endpoint.
     * @param mixed $data The request data.
     * @return mixed The response data.
     * @throws HttpException
     */
    public function delete(string $endpoint, array $data)
    {
        return $this->request('DELETE', $endpoint, $data);
    }
}
