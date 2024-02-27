<?php
namespace Basler\Trackingcode\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Sales\Api\Data\ShipmentTrackInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{
    /**
     * Constructor Class
     *
     * @param \Magento\Framework\App\Helper\Context $context
     * @param \Magento\Framework\Serialize\Serializer\Json $serializer
     */
    public function __construct(
        Context $context,
        private Json $serializer
    ) {
        parent::__construct($context);
    }

    /**
     * Get Tracking URL
     *
     * @param \Magento\Sales\Api\Data\ShipmentTrackInterface $track
     * @return string
     */
    public function getTrackingUrl(ShipmentTrackInterface $track): string|false
    {
        if ($url = $this->getUrl(strtolower($track->getTitle()))) {
            $url = str_replace('{number}', $track->getTrackNumber(), $url);
            return $url;
        }
        return false;
    }

    /**
     * Get Tracking URL
     *
     * @param string $carrierCode
     * @return string
     */
    public function getUrl(string $carrierCode): string|false
    {
        $urls = $this->getCarriersUrl();
        if (isset($urls[$carrierCode])) {
            return $urls[$carrierCode];
        }
        return false;
    }

    /**
     * Get Custom Carriers
     *
     * @return array
     */
    public function getCustomCarriers(): array
    {
        $carriers = [];
        $items = $this->serializer->unserialize($this->getCustomCarriersConfig());
        foreach ($items as $item) {
            $carriers[strtolower($item['value'])] = $item['value'];
        }
        return $carriers;
    }

    /**
     * Get Carriers Url
     *
     * @return array
     */
    public function getCarriersUrl(): array
    {
        $urls = [];
        $items = $this->serializer->unserialize($this->getCarriersUrlConfig());
        foreach ($items as $item) {
            $urls[strtolower($item['value'])] = $item['label'];
        }
        return $urls;
    }

    /**
     * Get Carriers Url Config
     *
     * @return string
     */
    public function getCarriersUrlConfig(): string
    {
        return (string) $this->scopeConfig->getValue(
            'basler_trackingcode/shipping/urls',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Get Custom Carriers Config
     *
     * @return string
     */
    public function getCustomCarriersConfig(): string
    {
        return (string) $this->scopeConfig->getValue(
            'basler_trackingcode/shipping/carrier',
            ScopeInterface::SCOPE_STORE
        );
    }

    /**
     * Is Modoule enabled?
     *
     * @param string $scope
     * @return boolean
     */
    public function isEnabled(
        string $scope = ScopeConfigInterface::SCOPE_TYPE_DEFAULT
    ): bool {
        return $this->scopeConfig->isSetFlag('basler_trackingcode/general/enabled', $scope);
    }
}
