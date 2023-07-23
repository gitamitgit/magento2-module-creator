<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Model;

use A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface;
use A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterfaceFactory;
use A2bizz\ModuleCreator\Api\Data\ModuleCreatorSearchResultsInterfaceFactory;
use A2bizz\ModuleCreator\Api\ModuleCreatorRepositoryInterface;
use A2bizz\ModuleCreator\Model\ResourceModel\ModuleCreator as ResourceModuleCreator;
use A2bizz\ModuleCreator\Model\ResourceModel\ModuleCreator\CollectionFactory as ModuleCreatorCollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class ModuleCreatorRepository implements ModuleCreatorRepositoryInterface
{

    /**
     * @var ModuleCreatorCollectionFactory
     */
    protected $modulecreatorCollectionFactory;

    /**
     * @var ModuleCreator
     */
    protected $searchResultsFactory;

    /**
     * @var CollectionProcessorInterface
     */
    protected $collectionProcessor;

    /**
     * @var ResourceModuleCreator
     */
    protected $resource;

    /**
     * @var ModuleCreatorInterfaceFactory
     */
    protected $modulecreatorFactory;


    /**
     * @param ResourceModuleCreator $resource
     * @param ModuleCreatorInterfaceFactory $modulecreatorFactory
     * @param ModuleCreatorCollectionFactory $modulecreatorCollectionFactory
     * @param ModuleCreatorSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface $collectionProcessor
     */
    public function __construct(
        ResourceModuleCreator $resource,
        ModuleCreatorInterfaceFactory $modulecreatorFactory,
        ModuleCreatorCollectionFactory $modulecreatorCollectionFactory,
        ModuleCreatorSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor
    ) {
        $this->resource = $resource;
        $this->modulecreatorFactory = $modulecreatorFactory;
        $this->modulecreatorCollectionFactory = $modulecreatorCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @inheritDoc
     */
    public function save(ModuleCreatorInterface $modulecreator)
    {
        try {
            $this->resource->save($modulecreator);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the modulecreator: %1',
                $exception->getMessage()
            ));
        }
        return $modulecreator;
    }

    /**
     * @inheritDoc
     */
    public function get($modulecreatorId)
    {
        $modulecreator = $this->modulecreatorFactory->create();
        $this->resource->load($modulecreator, $modulecreatorId);
        if (!$modulecreator->getId()) {
            throw new NoSuchEntityException(__('ModuleCreator with id "%1" does not exist.', $modulecreatorId));
        }
        return $modulecreator;
    }

    /**
     * @inheritDoc
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->modulecreatorCollectionFactory->create();
        
        $this->collectionProcessor->process($criteria, $collection);
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        
        $items = [];
        foreach ($collection as $model) {
            $items[] = $model;
        }
        
        $searchResults->setItems($items);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function delete(ModuleCreatorInterface $modulecreator)
    {
        try {
            $modulecreatorModel = $this->modulecreatorFactory->create();
            $this->resource->load($modulecreatorModel, $modulecreator->getModuleCreatorId());
            $this->resource->delete($modulecreatorModel);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the ModuleCreator: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * @inheritDoc
     */
    public function deleteById($modulecreatorId)
    {
        return $this->delete($this->get($modulecreatorId));
    }
}