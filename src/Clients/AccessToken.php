<?php

namespace NextDeveloper\Vinchin\Clients;

use NextDeveloper\Vinchin\Exceptions\HttpException;

class AccessToken
{
    private const URL = 'https://10.128.0.8:8080/api';
    private const ENDPOINT = '/access_token';

    /**
     * Retrieves the access token.
     *
     * @param string $username The username.
     * @param string $password The password.
     * @return string The access token.
     * @throws \Exception If an error occurs during the request, or if the access token is not found.
     */
    public function get(string $username, string $password): string
    {
        $queryParams = http_build_query([
            'user_name' => $username,
            'password' => $password
        ]);

        $url = self::URL . '/' . ltrim(self::ENDPOINT, '/') . '?' . $queryParams;

        $response = $this->executeRequest($url);

        if (!isset($response['data']['access_token'])) {
            throw new \Exception('Access token not found');
        }

        return $response['data']['access_token'];
    }

    /**
     * Executes the HTTP request.
     *
     * @param string $url The URL of the request.
     * @return array The response data.
     * @throws \Exception If an error occurs during the request.
     */
    private function executeRequest(string $url): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/vnd.vinchin-v1+json;charset=utf-8',
                'Accept: application/vnd.vinchin-v1+json',
            ],
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new HttpException('Curl error: ' . curl_error($ch), curl_errno($ch));
        }

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($statusCode < 200 || $statusCode >= 300) {
            throw new HttpException('HTTP Error: ' . $statusCode . ' Response: ' . $response, $statusCode);
        }

        curl_close($ch);

        return json_decode($response, true);
    }
}
