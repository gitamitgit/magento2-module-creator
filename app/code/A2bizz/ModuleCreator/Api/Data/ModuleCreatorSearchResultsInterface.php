<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Api\Data;

interface ModuleCreatorSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{

    /**
     * Get ModuleCreator list.
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface[]
     */
    public function getItems();

    /**
     * Set modulecreator_id list.
     * @param \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface[] $items
     * @return $this
     */
    public function setItems(array $items);
}

