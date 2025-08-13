<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Controller\Adminhtml\Log;

use Magento\Framework\View\Result\Page;
use PCode\ZadanieJeden\Controller\Adminhtml\AbstractGetAction;

class Index extends AbstractGetAction
{
    public const ADMIN_RESOURCE = 'PCode_ZadanieJeden::log';

    public function execute(): Page
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('PCode_ZadanieJeden::log');
        $resultPage
            ->getConfig()
            ->getTitle()
            ->prepend(__('ZadanieJeden Log'));

        return $resultPage;
    }
}
