<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Controller\Adminhtml\Log;

use Magento\Framework\View\Result\Page;
use PCode\ZadanieJeden\Controller\Adminhtml\AbstractGetAction;

class View extends AbstractGetAction
{
    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('PCode_ZadanieJeden::log');
        $resultPage->addBreadcrumb(__('ZadanieJeden'), __('Log'));
        $resultPage
            ->getConfig()
            ->getTitle()
            ->prepend(__('ZadanieJeden Log'));

        return $resultPage;
    }
}
