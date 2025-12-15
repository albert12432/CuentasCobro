<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\DianService;
use App\Services\DianDrivers\SetDriver;
use App\Services\DianDrivers\ProductionDriver;

class DianServiceTest extends TestCase
{
    /**
     * Test that DianService can be instantiated with SET environment.
     */
    public function test_can_instantiate_with_set_environment(): void
    {
        $service = new DianService('set');
        
        $this->assertInstanceOf(DianService::class, $service);
        $this->assertEquals('set', $service->getEnvironment());
        $this->assertInstanceOf(SetDriver::class, $service->getDriver());
    }

    /**
     * Test that DianService can be instantiated with Production environment.
     */
    public function test_can_instantiate_with_production_environment(): void
    {
        $service = new DianService('production');
        
        $this->assertInstanceOf(DianService::class, $service);
        $this->assertEquals('production', $service->getEnvironment());
        $this->assertInstanceOf(ProductionDriver::class, $service->getDriver());
    }

    /**
     * Test that DianService defaults to SET environment.
     */
    public function test_defaults_to_set_environment(): void
    {
        $service = new DianService();
        
        $this->assertEquals('set', $service->getEnvironment());
        $this->assertInstanceOf(SetDriver::class, $service->getDriver());
    }

    /**
     * Test that invalid environment defaults to SET.
     */
    public function test_invalid_environment_defaults_to_set(): void
    {
        $service = new DianService('invalid');
        
        $this->assertEquals('set', $service->getEnvironment());
        $this->assertInstanceOf(SetDriver::class, $service->getDriver());
    }

    /**
     * Test that sendDocument returns expected structure with SET driver.
     */
    public function test_send_document_with_set_driver(): void
    {
        $service = new DianService('set');
        $documentData = ['test' => 'data'];
        
        $result = $service->sendDocument($documentData);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('environment', $result);
        $this->assertEquals('set', $result['environment']);
        $this->assertTrue($result['success']);
    }

    /**
     * Test that sendDocument returns expected structure with Production driver.
     */
    public function test_send_document_with_production_driver(): void
    {
        $service = new DianService('production');
        $documentData = ['test' => 'data'];
        
        $result = $service->sendDocument($documentData);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('environment', $result);
        $this->assertEquals('production', $result['environment']);
        $this->assertTrue($result['success']);
    }

    /**
     * Test that queryDocumentStatus returns expected structure with SET driver.
     */
    public function test_query_document_status_with_set_driver(): void
    {
        $service = new DianService('set');
        $documentId = 'TEST-123';
        
        $result = $service->queryDocumentStatus($documentId);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('environment', $result);
        $this->assertEquals('set', $result['environment']);
        $this->assertTrue($result['success']);
    }

    /**
     * Test that queryDocumentStatus returns expected structure with Production driver.
     */
    public function test_query_document_status_with_production_driver(): void
    {
        $service = new DianService('production');
        $documentId = 'TEST-123';
        
        $result = $service->queryDocumentStatus($documentId);
        
        $this->assertIsArray($result);
        $this->assertArrayHasKey('success', $result);
        $this->assertArrayHasKey('status', $result);
        $this->assertArrayHasKey('environment', $result);
        $this->assertEquals('production', $result['environment']);
        $this->assertTrue($result['success']);
    }

    /**
     * Test that validateConfiguration works with SET driver.
     */
    public function test_validate_configuration_with_set_driver(): void
    {
        $config = [
            'test_set_id' => 'test-id',
            'software_id' => 'software-id'
        ];
        
        $service = new DianService('set', $config);
        
        $this->assertTrue($service->validateConfiguration());
    }

    /**
     * Test that validateConfiguration works with Production driver.
     */
    public function test_validate_configuration_with_production_driver(): void
    {
        $config = [
            'software_id' => 'software-id',
            'certificate_path' => '/path/to/cert.p12'
        ];
        
        $service = new DianService('production', $config);
        
        $this->assertTrue($service->validateConfiguration());
    }

    /**
     * Test that validateConfiguration fails with incomplete SET config.
     */
    public function test_validate_configuration_fails_with_incomplete_set_config(): void
    {
        $config = [
            'test_set_id' => 'test-id'
            // missing software_id
        ];
        
        $service = new DianService('set', $config);
        
        $this->assertFalse($service->validateConfiguration());
    }

    /**
     * Test that validateConfiguration fails with incomplete Production config.
     */
    public function test_validate_configuration_fails_with_incomplete_production_config(): void
    {
        $config = [
            'software_id' => 'software-id'
            // missing certificate_path
        ];
        
        $service = new DianService('production', $config);
        
        $this->assertFalse($service->validateConfiguration());
    }
}
