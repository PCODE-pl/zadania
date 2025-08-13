<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Controller\Adminhtml;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\View\Result\PageFactory;

abstract class AbstractGetAction extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'PCode_ZadanieJeden::log';

    public function __construct(
        Context $context,
        protected readonly PageFactory $resultPageFactory,
    ) {
        parent::__construct($context);
    }
}
