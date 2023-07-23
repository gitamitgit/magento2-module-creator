<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreatorGraphQl\Model\Resolver;

use A2bizz\ModuleCreator\Api\ModuleCreatorRepositoryInterface;
use A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

/**
 * ModuleCreator field resolver, used for GraphQL request processing
 */
class ModuleCreator implements ResolverInterface
{
    /**
     * @var ModuleCreatorRespository
     */
    private $moduleCreatorRepository;

    public function __construct(
        ModuleCreatorRepositoryInterface $moduleCreatorRepository
    ){
        $this->moduleCreatorRepository = $moduleCreatorRepository;
    }

    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        //print_r($args);exit;
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Module id should be specified'));
        }

        $moduleData = [];

        
        //return $args;
        //echo "AMIT<pre>";print_r($args['id']);exit;
        try {
            if (isset($args['id'])) {
                $moduleData = $this->moduleCreatorRepository->get((int)$args['id']);
            }
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__($e->getMessage()), $e);
        }
        return $this->convertData($moduleData);
    }

    /**
     * Convert moduleCreator data
     *
     * @param ModuleCreatorInterface $moduleCreator
     * @return array
     * @throws NoSuchEntityException
     */
    private function convertData(ModuleCreatorInterface $moduleCreator)
    {
        //if (false === $moduleCreator->isActive()) {
          //  throw new NoSuchEntityException();
        //}

        //$renderedContent = $this->widgetFilter->filter($page->getContent());

        $pageData = [
            ModuleCreatorInterface::NNAMESPACE => $moduleCreator->getNamespace(),
            ModuleCreatorInterface::MODULE => $moduleCreator->getModule(),
            ModuleCreatorInterface::CONTENT => $moduleCreator->getContent(),
            ModuleCreatorInterface::CREATION_TIME => $moduleCreator->getCreationTime(),
            ModuleCreatorInterface::UPDATE_TIME => $moduleCreator->getUpdateTime(),
            /*PageInterface::CONTENT_HEADING => $page->getContentHeading(),
            PageInterface::PAGE_LAYOUT => $page->getPageLayout(),
            PageInterface::META_TITLE => $page->getMetaTitle(),
            PageInterface::META_DESCRIPTION => $page->getMetaDescription(),
            PageInterface::META_KEYWORDS => $page->getMetaKeywords(),
            PageInterface::PAGE_ID => $page->getId(),
            PageInterface::IDENTIFIER => $page->getIdentifier(),*/
        ];
        return $pageData;
    }
}