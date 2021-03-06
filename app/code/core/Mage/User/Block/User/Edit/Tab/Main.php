<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_User
 * @copyright   Copyright (c) 2012 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Cms page edit form main tab
 *
 * @category   Mage
 * @package    Mage_User
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Mage_User_Block_User_Edit_Tab_Main extends Mage_Backend_Block_Widget_Form
{

    protected function _prepareForm()
    {
        $model = Mage::registry('permissions_user');

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('user_');

        $fieldset = $form->addFieldset(
            'base_fieldset',
            array('legend'=>Mage::helper('Mage_User_Helper_Data')->__('Account Information'))
        );

        if ($model->getUserId()) {
            $fieldset->addField('user_id', 'hidden', array(
                'name' => 'user_id',
            ));
        } else {
            if (! $model->hasData('is_active')) {
                $model->setIsActive(1);
            }
        }

        $fieldset->addField('username', 'text', array(
            'name'  => 'username',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('User Name'),
            'id'    => 'username',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('User Name'),
            'required' => true,
        ));

        $fieldset->addField('firstname', 'text', array(
            'name'  => 'firstname',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('First Name'),
            'id'    => 'firstname',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('First Name'),
            'required' => true,
        ));

        $fieldset->addField('lastname', 'text', array(
            'name'  => 'lastname',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('Last Name'),
            'id'    => 'lastname',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('Last Name'),
            'required' => true,
        ));

        $fieldset->addField('email', 'text', array(
            'name'  => 'email',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('Email'),
            'id'    => 'customer_email',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('User Email'),
            'class' => 'required-entry validate-email',
            'required' => true,
        ));

        if ($model->getUserId()) {
            $this->_addRegisteredUserPasswordFields($fieldset);
        } else {
            $this->_addNewUserPasswordFields($fieldset);
        }

        if (Mage::getSingleton('Mage_Backend_Model_Auth_Session')->getUser()->getId() != $model->getUserId()) {
            $fieldset->addField('is_active', 'select', array(
                'name'  	=> 'is_active',
                'label' 	=> Mage::helper('Mage_User_Helper_Data')->__('This account is'),
                'id'    	=> 'is_active',
                'title' 	=> Mage::helper('Mage_User_Helper_Data')->__('Account Status'),
                'class' 	=> 'input-select',
                'style'		=> 'width: 80px',
                'options'	=> array(
                    '1' => Mage::helper('Mage_User_Helper_Data')->__('Active'),
                    '0' => Mage::helper('Mage_User_Helper_Data')->__('Inactive')
                ),
            ));
        }

        $fieldset->addField('user_roles', 'hidden', array(
            'name' => 'user_roles',
            'id'   => '_user_roles',
        ));

        $data = $model->getData();

        unset($data['password']);

        $form->setValues($data);

        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Add password change fields in registered user edit form
     *
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     */
    protected function _addRegisteredUserPasswordFields(Varien_Data_Form_Element_Fieldset $fieldset)
    {
        $fieldset->addField('password', 'password', array(
            'name'  => 'new_password',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('New Password'),
            'id'    => 'new_pass',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('New Password'),
            'class' => 'input-text validate-admin-password',
        ));

        $fieldset->addField('confirmation', 'password', array(
            'name'  => 'password_confirmation',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('Password Confirmation'),
            'id'    => 'confirmation',
            'class' => 'input-text validate-cpassword',
        ));
    }

    /**
     * Add password creation fields in new user form
     *
     * @param Varien_Data_Form_Element_Fieldset $fieldset
     */
    protected function _addNewUserPasswordFields(Varien_Data_Form_Element_Fieldset $fieldset)
    {
        $fieldset->addField('password', 'password', array(
            'name'  => 'password',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('Password'),
            'id'    => 'customer_pass',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('Password'),
            'class' => 'input-text required-entry validate-admin-password',
            'required' => true,
        ));
        $fieldset->addField('confirmation', 'password', array(
            'name'  => 'password_confirmation',
            'label' => Mage::helper('Mage_User_Helper_Data')->__('Password Confirmation'),
            'id'    => 'confirmation',
            'title' => Mage::helper('Mage_User_Helper_Data')->__('Password Confirmation'),
            'class' => 'input-text required-entry validate-cpassword',
            'required' => true,
        ));
    }
}
