<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mageworx.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 * or send an email to sales@mageworx.com
 *
 * @category   MageWorx
 * @package    MageWorx_Adminhtml
 * @copyright  Copyright (c) 2009 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * MageWorx Adminhtml extension
 *
 * @category   MageWorx
 * @package    MageWorx_Adminhtml
 * @author     MageWorx Dev Team <dev@mageworx.com>
 */
class MageWorx_Adminhtml_Block_Customoptions_Options_Edit_Tab_Options_Groups extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {
        $product = Mage::registry('product');
        if ($product->getTypeId() == 'bundle' && $product->getPriceType() == 0) {
            return $this;
        }
        $values = Mage::getSingleton('customoptions/group')->getStoreValues($product->getStoreId());

        $form = new Varien_Data_Form();
        $form->addField('customoptions_groups', 'multiselect', array(
            'label' => Mage::helper('customoptions')->__('Predefined Options'),
            'title' => Mage::helper('customoptions')->__('Predefined Options'),
            'name' => 'customoptions[groups][]',
            'values' => $values,
            'value' => Mage::getResourceSingleton('customoptions/relation')->getGroupIds($product->getId()),
            'style' => 'width: 280px; height: 112px;',
        ));
        $this->setForm($form);

        return parent::_prepareForm();
    }

}