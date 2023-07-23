<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ModuleCreator extends AbstractDb
{

    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('a2bizz_modulecreator', 'modulecreator_id');
    }
}

