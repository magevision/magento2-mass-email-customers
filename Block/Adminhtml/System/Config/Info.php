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
namespace MageVision\MassEmailCustomers\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Context;
use Magento\Framework\Data\Form\Element\AbstractElement;
use MageVision\MassEmailCustomers\Helper\Data as Helper;
use Magento\Backend\Block\AbstractBlock;
use Magento\Framework\Data\Form\Element\Renderer\RendererInterface;

class Info extends AbstractBlock implements RendererInterface
{
    /**
     * @var Helper
     */
    protected $helper;
    
    /**
     * Constructor
     * @param Context $context
     * @param Helper $helper
     */
    public function __construct(
        Context $context,
        Helper $helper
    ) {
        $this->helper = $helper;
        parent::__construct($context);
    }
    
    /**
     * Render form element as HTML
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $version  = $this->helper->getExtensionVersion();
        $name = $this->helper->getExtensionName();
        $logoUrl = 'https://www.magevision.com/pub/media/logo/default/magevision.png';
        
        $html  = <<<HTML
<div style="background: url('$logoUrl') no-repeat scroll 15px 15px #fff;
border:1px solid #e3e3e3; min-height:100px; display;block;
padding:15px 15px 15px 130px;">
<p>
<strong>$name Extension v$version</strong> by <strong><a href="https://www.magevision.com" target="_blank">MageVision</a></strong><br />
Send mass emails to your customers from the admin sales order grid and customer grid in Magento admin.</p>
<p>
Check more extensions you might be interested in our <a href="https://www.magevision.com/magento-2-extensions" target="_blank">website</a>.
<br />Like and follow us on 
<a href="https://www.facebook.com/magevision" target="_blank">Facebook</a>,
<a href="https://www.linkedin.com/company/magevision" target="_blank">LinkedIn</a> and
<a href="https://twitter.com/magevision" target="_blank">Twitter</a>.<br />
If you need support or have any questions, please contact us at
<a href="mailto:support@magevision.com">support@magevision.com</a>.
</p>
</div>
HTML;
        return $html;
    }
}
