<?php

namespace NextDeveloper\Vinchin\Requests;

use NextDeveloper\Vinchin\Types\AvailableVirtualizationType;
use NextDeveloper\Vinchin\Types\MicrosoftVirtualizationType;
use NextDeveloper\Vinchin\Exceptions\Http422UnprocessableEntity;

class VirtualizationParameters
{
    /**
     * Validates the required parameters.
     *
     * @param array $data The data to validate.
     * @param array $requiredParams The list of required parameters.
     * @throws Http422UnprocessableEntity If required, parameters are missing or invalid.
     */
    public static function validateParameters(array $data, array $requiredParams): void
    {
        foreach ($requiredParams as $param) {
            // Check if the key exists in the data
            if (!array_key_exists($param, $data)) {
                throw new Http422UnprocessableEntity("The parameter '$param' is required");
            }

            // Validate 'hypervisor' parameter
            if ($param === 'hypervisor') {
                self::validateHypervisor($data[$param]);
            }

            // Validate 'detail' parameter based on 'hypervisor' value
            if (isset($data['hypervisor'])) {
                self::validateDetail($data);
            }
        }
    }

    /**
     * Validate 'hypervisor' parameter.
     *
     * @param int $hypervisor The value of 'hypervisor'.
     * @throws Http422UnprocessableEntity If 'hypervisor' value is invalid.
     */
    private static function validateHypervisor(int $hypervisor): void
    {
        if (!AvailableVirtualizationType::tryFrom($hypervisor)) {
            throw new Http422UnprocessableEntity("The value of the parameter 'hypervisor' is invalid");
        }
    }

    /**
     * Validate 'detail' parameter based on 'hypervisor' value.
     *
     * @param array $data The data containing 'detail'.
     * @throws Http422UnprocessableEntity If 'detail' parameters are missing or invalid.
     */
    private static function validateDetail(array $data): void
    {
        $hypervisor = $data['hypervisor'];

        if ($hypervisor === 2) {
            self::validateMicrosoftDetail($data);
        } elseif ($hypervisor === 15) {
            self::validateKeystoneDetail($data);
        }
    }

    /**
     * Validate 'detail' parameters for Microsoft Virtualization.
     *
     * @param array $data The data containing 'detail'.
     * @throws Http422UnprocessableEntity If 'detail' parameters are missing or invalid.
     */
    private static function validateMicrosoftDetail(array $data): void
    {
        $detail = $data['detail'] ?? [];

        if (!array_key_exists('type', $detail)) {
            throw new Http422UnprocessableEntity("The parameter 'type' is required for Microsoft Virtualization");
        }

        $type = $detail['type'];
        if (!MicrosoftVirtualizationType::tryFrom($type)) {
            throw new Http422UnprocessableEntity("The value of the parameter 'type' is invalid for Microsoft Virtualization");
        }
    }

    /**
     * Validate 'detail' parameters for Keystone.
     *
     * @param array $data The data containing 'detail'.
     * @throws Http422UnprocessableEntity If 'detail' parameters are missing or invalid.
     */
    private static function validateKeystoneDetail(array $data): void
    {
        $detail = $data['detail'] ?? [];

        $requiredParams = ['keystone_public_port', 'keystone_admin_port', 'tenant_name', 'keystone_version'];

        if (!array_key_exists('keystone_version', $detail) || $detail['keystone_version'] != 3) {
            $requiredParams[] = 'domain';
        }

        self::validateParameters($detail, $requiredParams);
    }

    /**
     * Validates that the data is an array.
     *
     * @param array $data The data to validate.
     * @param string $key The key of the data.
     * @throws Http422UnprocessableEntity If the data is not an array.
     */
    public static function validateArray(array $data, string $key): void
    {
        if (!is_array($data)) {
            throw new Http422UnprocessableEntity("The parameter '$key' must be an array");
        }
    }
}
