<?php

declare(strict_types=1);

namespace PCode\ZadanieJeden\Ui\Component\Listing\Column;

use Magento\Ui\Component\Listing\Columns\Column;

class ChangeLogActions extends Column
{
    public function prepareDataSource(array $dataSource): array
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as &$item) {
            $item[$this->getData('name')]['details'] = [
                'href' => $this->context->getUrl(
                    'zadaniejeden/log/view',
                    ['entity_id' => $item['entity_id']],
                ),
                'label' => __('View'),
            ];
        }

        return $dataSource;
    }
}
