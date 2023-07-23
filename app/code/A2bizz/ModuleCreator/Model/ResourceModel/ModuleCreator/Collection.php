<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Model\ResourceModel\ModuleCreator;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    /**
     * @inheritDoc
     */
    protected $_idFieldName = 'modulecreator_id';

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init(
            \A2bizz\ModuleCreator\Model\ModuleCreator::class,
            \A2bizz\ModuleCreator\Model\ResourceModel\ModuleCreator::class
        );
    }
}

