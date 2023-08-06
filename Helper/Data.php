<?php

declare(strict_types=1);

namespace Gokhandemirer\ExpressShipping\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    /**
     * @param Context $context
     */
    public function __construct(
        Context $context
    ) {
        parent::__construct($context);
    }

    /**
     * @param float $weight
     * @return float
     */
    public function getShippingCost(float $weight): float
    {
        $baseCost = Config::BASE_SHIPPING_COST;
        $additionalCost = Config::ADDITIONAL_SHIPPING_COST;

        if ($weight <= 5) {
            $shippingCost = $baseCost;
        } else {
            $extraWeight = $weight - 5;
            $shippingCost = $baseCost + ($extraWeight * $additionalCost);
        }

        return $shippingCost;
    }
}
