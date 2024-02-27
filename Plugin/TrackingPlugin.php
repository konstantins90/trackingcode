<?php
/**
 * Class TrackingPlugin
 *
 * @author: Basler AG
 * @author Konstantin Smetana <konstantin.smetana@baslerweb.com>
 * @copyright 2024 Basler AG
 * @link: https://baslerweb.com
 */
declare(strict_types=1);
namespace Basler\Trackingcode\Plugin;

use Magento\Shipping\Block\Adminhtml\Order\Tracking;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Basler\Trackingcode\Helper\Data as TrackingcodeHelper;

class TrackingPlugin
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param TrackingcodeHelper $trackingcodeHelper
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig,
        private TrackingcodeHelper $trackingcodeHelper
    ) {
    }

    /**
     * Retrieve carriers
     *
     * @param \Magento\Shipping\Block\Adminhtml\Order\Tracking $subject
     * @param array $result
     * @return array
     */
    public function afterGetCarriers(Tracking $subject, array $result): array
    {
        if ($this->trackingcodeHelper->isEnabled()) {
            $carriers = $this->trackingcodeHelper->getCustomCarriers();
            $result = array_merge($result, $carriers);
        }
        return $result;
    }
}
