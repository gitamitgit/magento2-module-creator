<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Model;

use A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface;
use Magento\Framework\Model\AbstractModel;

class ModuleCreator extends AbstractModel implements ModuleCreatorInterface
{

    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @inheritDoc
     */
    public function _construct()
    {
        $this->_init(\A2bizz\ModuleCreator\Model\ResourceModel\ModuleCreator::class);
    }

    /**
     * @inheritDoc
     */
    public function getModuleCreatorId()
    {
        return $this->getData(self::ID);
    }

    /**
     * @inheritDoc
     */
    public function setModuleCreatorId($modulecreatorId)
    {
        return $this->setData(self::ID, $modulecreatorId);
    }

    /**
     * @inheritDoc
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * @inheritDoc
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * @inheritDoc
     */
    public function getNamespace()
    {
        return $this->getData(self::NNAMESPACE);
    }

    /**
     * @inheritDoc
     */
    public function setNamespace($namespace)
    {
        return $this->setData(self::NNAMESPACE, $namespace);
    }

    /**
     * @inheritDoc
     */
    public function getModule()
    {
        return $this->getData(self::MODULE);
    }

    /**
     * @inheritDoc
     */
    public function setModule($module)
    {
        return $this->setData(self::MODULE, $module);
    }

    /**
     * @inheritDoc
     */
    public function getContent()
    {
        return $this->getData(self::CONTENT);
    }

    /**
     * @inheritDoc
     */
    public function setContent($content)
    {
        return $this->setData(self::CONTENT, $content);
    }

    /**
     * @inheritDoc
     */
    public function getCreationTime()
    {
        return $this->getData(self::CREATION_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setCreationTime($creationTime)
    {
        return $this->setData(self::CREATION_TIME, $creationTime);
    }

    /**
     * @inheritDoc
     */
    public function getUpdateTime()
    {
        return $this->getData(self::UPDATE_TIME);
    }

    /**
     * @inheritDoc
     */
    public function setUpdateTime($updateTime)
    {
        return $this->setData(self::UPDATE_TIME, $updateTime);
    }

    /**
     * @inheritDoc
     */
    public function getIsActive()
    {
        return $this->getData(self::IS_ACTIVE);
    }

    /**
     * @inheritDoc
     */
    public function setIsActive($isActive)
    {
        return $this->setData(self::IS_ACTIVE, $isActive);
    }

    /**
     * Prepare statuses, available event module_creator_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
}

