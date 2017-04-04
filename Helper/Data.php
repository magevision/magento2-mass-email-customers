<?php
/**
 * MageVision Mass Email Customers Extension
 *
 * @category     MageVision
 * @package      MageVision_MassEmailCustomers
 * @author       MageVision Team
 * @copyright    Copyright (c) 2016 MageVision (http://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\MassEmailCustomers\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Framework\Module\ModuleListInterface;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_EMAIL_SENDER     = 'massemailcustomers/email/identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'massemailcustomers/email/template';
    const MODULE_NAME               = 'Mass Email Customers';
    const MODULE_VERSION            = 'MageVision_MassEmailCustomers';

    /**
     * @var \Magento\Framework\Mail\Template\TransportBuilder
     */
    protected $transportBuilder;
    
    /**
     * @var \Magento\Framework\Translate\Inline\StateInterface
     */
    protected $inlineTranslation;

    /**
     * @var \Magento\Framework\Module\ModuleListInterface;
     */
    protected $moduleList;
    
    /**
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param StateInterface $inlineTranslation
     * @param ModuleListInterface $moduleList
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        StateInterface $inlineTranslation,
        ModuleListInterface $moduleList
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->inlineTranslation = $inlineTranslation;
        $this->moduleList = $moduleList;
        parent::__construct($context);
    }
    
    /**
     * Retrieve Sender
     *
     * @param int $store
     * @return mixed
     */
    public function getSender($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_SENDER,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * Retrieve Email Template
     *
     * @param int $store
     * @return mixed
     */
    public function getEmailTemplate($store = null)
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_EMAIL_TEMPLATE,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $store
        );
    }

    /**
     * @param object $item
     * @return $this
     */
    public function send($item)
    {
        $this->inlineTranslation->suspend();
        
        if ($item instanceof \Magento\Sales\Model\Order) {
            $email = $item->getCustomerEmail();
            $orderId = $item->getIncrementId();
            if (!$item->getCustomerIsGuest()) {
                $name = $item->getCustomerFirstname().' '.$item->getCustomerLastname();
            } else {
                $name = '';
            }
        } else {
            $email = $item->getEmail();
            $name = $item->getName();
            $orderId = '';
        }
        $storeId = $item->getData('store_id');
        $this->transportBuilder->setTemplateIdentifier(
            $this->getEmailTemplate($storeId)
        )->setTemplateOptions(
            [
                'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                'store' => $storeId,
            ]
        )->setFrom(
            $this->getSender($storeId)
        )->setTemplateVars(
            [
                'customer_name' => $name,
                'customer_email' => $email,
                'increment_id' => $orderId
            ]
        )->addTo(
            $email,
            $name
        );
        $transport = $this->transportBuilder->getTransport();
        $transport->sendMessage();

        $this->inlineTranslation->resume();

        return $this;
    }

    /**
     * Returns extension version.
     *
     * @return string
     */
    public function getExtensionVersion()
    {
        $moduleInfo = $this->moduleList->getOne(self::MODULE_VERSION);
        return $moduleInfo['setup_version'];
    }

    /**
     * Returns extension name.
     *
     * @return string
     */
    public function getExtensionName()
    {
        return self::MODULE_NAME;
    }
}
