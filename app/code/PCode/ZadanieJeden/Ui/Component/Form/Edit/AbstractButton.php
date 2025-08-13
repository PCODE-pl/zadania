<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Ui\Component\Form\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Store\Model\Store;

abstract class AbstractButton
{
    public function __construct(
        protected readonly Context $context,
    ) {
    }

    public function getUrl(string $route = '', array $params = []): string
    {
        if (empty($params[Store::STORE_ID])) {
            $params[Store::STORE_ID] = $this
                ->context
                ->getRequest()
                ->getParam(Store::STORE_ID);
        }

        return $this
            ->context
            ->getUrlBuilder()
            ->getUrl($route, $params);
    }
}
