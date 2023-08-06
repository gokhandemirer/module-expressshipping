<?php

declare(strict_types=1);

namespace Gokhandemirer\ExpressShipping\Helper;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Store\Model\ScopeInterface;

class Config extends AbstractHelper
{
    const HANDLING_FEE_CONFIG_PATH = 'carriers/expressshipping/handling_fee';
    const MAXIMUM_WEIGHT_CONFIG_PATH = 'carriers/expressshipping/max_weight_limit';

    const BASE_SHIPPING_COST = 10.0;

    const ADDITIONAL_SHIPPING_COST = 2.0;

    /**
     * @param Context $context
     */
    public function __construct(
        Context $context,
    ) {
        parent::__construct($context);
    }

    /**
     * @return float
     */
    public function getHandlingFee(): float
    {
        return (float) $this->scopeConfig->getValue(
            self::HANDLING_FEE_CONFIG_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @return float
     */
    public function getMaximumWeight(): float
    {
        return (float) $this->scopeConfig->getValue(
            self::MAXIMUM_WEIGHT_CONFIG_PATH,
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function setScopeConfig(ScopeConfigInterface $scopeConfig): void
    {
        $this->scopeConfig = $scopeConfig;
    }
}
