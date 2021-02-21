<?php
/**
 * MageVision Mass Email Customers Extension
 *
 * @category     MageVision
 * @package      MageVision_MassEmailCustomers
 * @author       MageVision Team
 * @copyright    Copyright (c) 2021 MageVision (http://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
declare(strict_types=1);

namespace MageVision\MassEmailCustomers\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    const XML_PATH_EMAIL_SENDER     = 'massemailcustomers/email/identity';
    const XML_PATH_EMAIL_TEMPLATE   = 'massemailcustomers/email/template';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
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
            ScopeInterface::SCOPE_STORE,
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
            ScopeInterface::SCOPE_STORE,
            $store
        );
    }
}
