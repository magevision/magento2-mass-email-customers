<?php
/**
 * MageVision Mass Email Customers Extension
 *
 * @category     MageVision
 * @package      MageVision_MassEmailCustomers
 * @author       MageVision Team
 * @copyright    Copyright (c) 2018 MageVision (http://www.magevision.com)
 * @license      http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
namespace MageVision\MassEmailCustomers\Controller\Adminhtml\Email;

use Magento\Framework\Controller\ResultFactory;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Backend\App\Action;
use Magento\Framework\Exception\LocalizedException;
use Magento\Customer\Model\ResourceModel\Customer\CollectionFactory as CustomerCollectionFactory;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory as SalesCollectionFactory;
use MageVision\MassEmailCustomers\Helper\Data as Helper;

class MassSend extends Action
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
     * @var CustomerCollectionFactory
     */
    protected $customerCollectionFactory;
    
    /**
     * @var Helper
     */
    protected $helper;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param Helper $helper
     * @param CustomerCollectionFactory $customerCollectionFactory
     * @param SalesCollectionFactory $salesCollectionFactory
     */
    public function __construct(
        Context $context,
        Filter $filter,
        Helper $helper,
        CustomerCollectionFactory $customerCollectionFactory,
        SalesCollectionFactory $salesCollectionFactory
    ) {
        $this->filter = $filter;
        $this->helper = $helper;
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
                $this->helper->send($item);
                $emailSent++;
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                break;
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Some emails were not sent.'));
                break;
            }
        }

        if ($emailSent) {
            $this->messageManager->addSuccessMessage(__('A total of %1 email(s) have been sent.', $emailSent));
        }

        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $resultRedirect->setUrl($this->_redirect->getRefererUrl());
    }
}
