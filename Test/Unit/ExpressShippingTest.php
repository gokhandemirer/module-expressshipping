<?php

declare(strict_types=1);

namespace Gokhandemirer\ExpressShipping\Test\Unit;

use Gokhandemirer\ExpressShipping\Helper\Config;
use Gokhandemirer\ExpressShipping\Helper\Data;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class ExpressShippingTest extends TestCase
{
    private Data $helper;

    private Config $configHelper;

    private ObjectManager $objectManager;

    protected function setUp(): void
    {
        $this->objectManager = new ObjectManager($this);

        $this->helper = $this->objectManager->getObject(Data::class);
        $this->configHelper = $this->objectManager->getObject(Config::class);
    }

    /**
     * Test the cost calculation logic for different order weights
     */
    public function testCostCalculation(): void
    {
        // Test cost for orders weighing up to 5 kg)
        $this->assertEquals(10.0, $this->helper->getShippingCost(5.0));

        // Test cost for orders weighing more than 5 kg
        $this->assertEquals(14.0, $this->helper->getShippingCost(7.0));
    }

    /**
     * Test the configuration settings for handling fee and maximum weight limit
     */
    public function testConfigurationSettings(): void
    {
        // Mock the configuration settings for the tests
        $handlingFee = 2.0;
        $maxWeightLimit = 10.0;

        // Set up the mocked scope config
        $scopeConfig = $this->getMockBuilder(ScopeConfigInterface::class)
            ->getMock();
        $scopeConfig->method('getValue')->willReturn($handlingFee, $maxWeightLimit);

        $this->configHelper->setScopeConfig($scopeConfig);

        // Assert that the handling fee and max weight limit are set correctly
        $this->assertEquals($handlingFee, $this->configHelper->getHandlingFee());
        $this->assertEquals($maxWeightLimit, $this->configHelper->getMaximumWeight());
    }
}
