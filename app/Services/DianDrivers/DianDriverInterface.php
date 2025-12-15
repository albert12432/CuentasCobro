<?php

namespace App\Services\DianDrivers;

/**
 * Interface for DIAN integration drivers.
 * 
 * Defines the contract that all DIAN drivers must implement,
 * allowing for easy switching between SET (testing) and Production environments.
 */
interface DianDriverInterface
{
    /**
     * Send a document to DIAN for validation and approval.
     *
     * @param array $documentData The document data to be sent
     * @return array Response from DIAN service
     */
    public function sendDocument(array $documentData): array;

    /**
     * Query the status of a previously sent document.
     *
     * @param string $documentId The document identifier
     * @return array Status information from DIAN
     */
    public function queryDocumentStatus(string $documentId): array;

    /**
     * Validate that the driver configuration is correct.
     *
     * @return bool True if configuration is valid
     */
    public function validateConfiguration(): bool;

    /**
     * Get the current environment (set or production).
     *
     * @return string The environment name
     */
    public function getEnvironment(): string;
}
