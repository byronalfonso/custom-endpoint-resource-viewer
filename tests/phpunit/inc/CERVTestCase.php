<?php
use PHPUnit\Framework\TestCase;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Brain\Monkey;


/**
 * Base test class for the CERV plugin
 */
class CERVTestCase extends \PHPUnit\Framework\TestCase {
    use MockeryPHPUnitIntegration;

    public function setUp(): void {
        parent::setUp();
        Monkey\setUp();
    }
    
    public function tearDown(): void {
        Monkey\tearDown();
        parent::tearDown();
    }
}