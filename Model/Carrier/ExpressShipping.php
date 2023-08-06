<?php

declare(strict_types=1);

namespace Gokhandemirer\ExpressShipping\Model\Carrier;

use Gokhandemirer\ExpressShipping\Helper\Config;
use Gokhandemirer\ExpressShipping\Helper\Data;
use Magento\Checkout\Model\Session;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Message\ManagerInterface;
use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory;
use Magento\Quote\Model\Quote\Address\RateResult\MethodFactory;
use Magento\Shipping\Model\Carrier\AbstractCarrier;
use Magento\Shipping\Model\Carrier\CarrierInterface;
use Magento\Shipping\Model\Rate\ResultFactory;
use Psr\Log\LoggerInterface;

class ExpressShipping extends AbstractCarrier implements CarrierInterface
{

    protected $_code = 'expressshipping';

    protected $_isFixed = true;

    protected $_rateResultFactory;

    protected $_rateMethodFactory;

    protected $checkoutSession;

    protected $messageManager;

    protected $config;

    protected $helper;

    /**
     * Constructor
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param ErrorFactory $rateErrorFactory
     * @param LoggerInterface $logger
     * @param ResultFactory $rateResultFactory
     * @param MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        ErrorFactory $rateErrorFactory,
        LoggerInterface $logger,
        ResultFactory $rateResultFactory,
        MethodFactory $rateMethodFactory,
        Session $checkoutSession,
        ManagerInterface $messageManager,
        Config $config,
        Data $helper,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->checkoutSession = $checkoutSession;
        $this->messageManager = $messageManager;
        $this->config = $config;
        $this->helper = $helper;

        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {
        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $result = $this->_rateResultFactory->create();
        $result->append($this->_getExpressShippingRate());

        return $result;
    }

    protected function _getExpressShippingRate()
    {
        $rate = $this->_rateMethodFactory->create();

        $rate->setCarrier($this->_code);
        $rate->setCarrierTitle($this->getConfigData('title'));

        $rate->setMethod($this->_code);
        $rate->setMethodTitle($this->getConfigData('name'));

        $handlingFee = $this->config->getHandlingFee();
        $maxWeightLimit = $this->config->getMaximumWeight();

        $quote = $this->checkoutSession->getQuote();
        $weight = $quote->getShippingAddress()->getWeight();

        if ($weight > $maxWeightLimit) {
            $this->messageManager->addErrorMessage(
                __('"ExpressShipping" is not available for the current order.')
            );
            return false;
        }

        $shippingCost = $this->helper->getShippingCost($weight);

        $rate->setPrice($shippingCost + $handlingFee);
        $rate->setCost($shippingCost);

        return $rate;
    }

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
