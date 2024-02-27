<?php
/*
 * @author: Basler AG
 * @author Konstantin Smetana <konstantin.smetana@baslerweb.com>
 * @copyright 2024 Basler AG
 * @link: https://baslerweb.com
 */
namespace Basler\Trackingcode\Block\Adminhtml\Config;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;

class Url extends AbstractFieldArray
{
    /**
     * Prepare Render
     *
     * @return void
     */
    protected function _prepareToRender()
    {
        $this->addColumn(
            'value',
            [
                'label' => __('Shipping Method'),
                'class' => 'required-entry',
            ]
        );

        $this->addColumn(
            'label',
            [
                'label' => __('URL'),
                'note' => __('text'),
            ]
        );

        $this->_addAfter = false;
    }
}
