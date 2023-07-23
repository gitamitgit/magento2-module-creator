<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace A2bizz\ModuleCreator\Api\Data;

interface ModuleCreatorInterface
{

    const ID = 'modulecreator_id';
    const TITLE = 'Title';
    const NNAMESPACE = 'namespace';
    const MODULE = 'module';
    const CONTENT = 'content';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME = 'update_time';
    const IS_ACTIVE = 'is_active';

    /**
     * Get modulecreator_id
     * @return string|null
     */
    public function getModuleCreatorId();

    /**
     * Set modulecreator_id
     * @param string $modulecreatorId
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setModuleCreatorId($modulecreatorId);

    /**
     * Get Title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set Title
     * @param string $title
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setTitle($title);

    /**
     * Get Namespace
     * @return string|null
     */
    public function getNamespace();

    /**
     * Set Namespace
     * @param string $namespace
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setNamespace($namespace);

    /**
     * Get Module
     * @return string|null
     */
    public function getModule();

    /**
     * Set Module
     * @param string $module
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setModule($module);

    /**
     * Get content
     * @return string|null
     */
    public function getContent();

    /**
     * Set content
     * @param string $content
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setContent($content);

    /**
     * Get creation_time
     * @return string|null
     */
    public function getCreationTime();

    /**
     * Set creation_time
     * @param string $creationTime
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setCreationTime($creationTime);

    /**
     * Get update_time
     * @return string|null
     */
    public function getUpdateTime();

    /**
     * Set update_time
     * @param string $updateTime
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setUpdateTime($updateTime);

    /**
     * Get is_active
     * @return string|null
     */
    public function getIsActive();

    /**
     * Set is_active
     * @param string $isActive
     * @return \A2bizz\ModuleCreator\Api\Data\ModuleCreatorInterface
     */
    public function setIsActive($isActive);
}

