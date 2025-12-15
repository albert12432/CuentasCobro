<?php

namespace App\Services;

use App\Services\DianDrivers\DianDriverInterface;
use App\Services\DianDrivers\SetDriver;
use App\Services\DianDrivers\ProductionDriver;

/**
 * DIAN Service
 * 
 * Main service class for interacting with DIAN (Dirección de Impuestos y Aduanas Nacionales).
 * Manages document submission, validation, and status queries using the appropriate driver.
 */
class DianService
{
    private DianDriverInterface $driver;
    private string $environment;

    /**
     * Create a new DianService instance.
     *
     * @param string $environment The environment to use ('set' or 'production')
     * @param array $config Configuration array for the driver
     */
    public function __construct(string $environment = 'set', array $config = [])
    {
        $this->driver = $this->createDriver($environment, $config);
        $this->environment = $this->driver->getEnvironment();
    }

    /**
     * Create the appropriate driver based on environment.
     *
     * @param string $environment The environment name
     * @param array $config Configuration array
     * @return DianDriverInterface The driver instance
     */
    private function createDriver(string $environment, array $config): DianDriverInterface
    {
        return match (strtolower($environment)) {
            'production' => new ProductionDriver($config),
            'set' => new SetDriver($config),
            default => new SetDriver($config),
        };
    }

    /**
     * Send a document to DIAN.
     *
     * @param array $documentData The document data to be sent
     * @return array Response from DIAN service
     */
    public function sendDocument(array $documentData): array
    {
        return $this->driver->sendDocument($documentData);
    }

    /**
     * Query the status of a document.
     *
     * @param string $documentId The document identifier
     * @return array Status information from DIAN
     */
    public function queryDocumentStatus(string $documentId): array
    {
        return $this->driver->queryDocumentStatus($documentId);
    }

    /**
     * Validate the current configuration.
     *
     * @return bool True if configuration is valid
     */
    public function validateConfiguration(): bool
    {
        return $this->driver->validateConfiguration();
    }

    /**
     * Get the current environment.
     *
     * @return string The environment name
     */
    public function getEnvironment(): string
    {
        return $this->environment;
    }

    /**
     * Get the current driver instance.
     *
     * @return DianDriverInterface The driver
     */
    public function getDriver(): DianDriverInterface
    {
        return $this->driver;
    }
}
