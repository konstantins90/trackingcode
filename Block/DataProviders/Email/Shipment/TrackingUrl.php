<?php
/**
 * Tracking URL for shipment email
 *
 * @author: Basler AG
 * @author Konstantin Smetana <konstantin.smetana@baslerweb.com>
 * @copyright 2024 Basler AG
 * @link: https://baslerweb.com
 */
declare(strict_types=1);

namespace Basler\Trackingcode\Block\DataProviders\Email\Shipment;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Sales\Model\Order\Shipment\Track;
use Basler\Trackingcode\Helper\Data as TrackingcodeHelper;
use Magento\Shipping\Helper\Data as ShippingHelper;

/**
 * Shipment track info for email
 */
class TrackingUrl implements ArgumentInterface
{
    /**
     * Constructor
     *
     * @param \Magento\Shipping\Helper\Data $helper
     * @param \Basler\Trackingcode\Helper\Data $trackingcodeHelper
     */
    public function __construct(
        private ShippingHelper $helper,
        private TrackingcodeHelper $trackingcodeHelper
    ) {
    }

    /**
     * Get Shipping tracking URL
     *
     * @param Track $track
     * @return string
     */
    public function getUrl(Track $track): string
    {
        if ($this->trackingcodeHelper->isEnabled()) {
            return $this->trackingcodeHelper->getTrackingUrl($track) ?: '#';
        }

        return $this->helper->getTrackingPopupUrlBySalesModel($track);
    }
}
