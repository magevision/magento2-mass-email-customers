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
namespace MageVision\MassEmailCustomers\Controller\Adminhtml\Email;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

class MassSend extends \Magento\Backend\App\Action
{
    /**
     * @var Filter
     */
    protected $filter;

    /**
     * @var salesCollectionFactory
     */
    protected $salesCollectionFactory;
    
    /**
     * @var customerCollectionFactory
     */
    protected $customerCollectionFactory;
    
    /**
     * @var \MageVision\MassEmailCustomers\Helper\Data
     */
    protected $massEmailCustomersHelper;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param \MageVision\MassEmailCustomers\Helper\Data $massEmailCustomersHelper
     * @param \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory
     * @param \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesCollectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        \MageVision\MassEmailCustomers\Helper\Data $massEmailCustomersHelper,
        \Magento\Customer\Model\ResourceModel\Customer\CollectionFactory $customerCollectionFactory,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $salesCollectionFactory
    ) {
        $this->filter = $filter;
        $this->massEmailCustomersHelper = $massEmailCustomersHelper;
        $this->customerCollectionFactory = $customerCollectionFactory;
        $this->salesCollectionFactory = $salesCollectionFactory;
        parent::__construct($context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     * @throws \Magento\Framework\Exception\LocalizedException|\Exception
     */
    public function execute()
    {
        $namespace = $this->getRequest()->getParam('namespace');
        
        if ($namespace == 'customer_listing') {
            $collection = $this->filter->getCollection($this->customerCollectionFactory->create());
        } else {
            $collection = $this->filter->getCollection($this->salesCollectionFactory->create());
        }
        $emailSent = 0;
        foreach ($collection as $item) {
            try {
                $this->massEmailCustomersHelper->send($item);
                $emailSent++;
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
                break;
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Some emails were not sent.'));
                break;
            }
        }

        if ($emailSent) {
            $this->messageManager->addSuccess(__('A total of %1 email(s) have been sent.', $emailSent));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }
}
