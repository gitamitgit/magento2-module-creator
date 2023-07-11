<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ModuleCreatorRepositoryInterface
{

    /**
     * Save ModuleCreator
     * @param \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface $modulecreator
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(
        \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface $modulecreator
    );

    /**
     * Retrieve ModuleCreator
     * @param string $modulecreatorId
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function get($modulecreatorId);

    /**
     * Retrieve ModuleCreator matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete ModuleCreator
     * @param \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface $modulecreator
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(
        \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface $modulecreator
    );

    /**
     * Delete ModuleCreator by ID
     * @param string $modulecreatorId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($modulecreatorId);
}

