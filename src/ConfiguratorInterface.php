<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\Config;

use Spiral\Core\ConfigsInterface;

/**
 * Provides ability to modify configs values in runtime.
 */
interface ConfiguratorInterface extends ConfigsInterface
{
    /**
     * Check if configuration sections exists or defined as default.
     *
     * @param string $section
     * @return bool
     */
    public function exists(string $section): bool;

    /**
     * Set default value for configuration section. Default values will be overwritten by user specified config
     * on first level only. Only one default value is allowed per configuration section, use modify method in order
     * to alter existed content.  Must throw `PatchDeliveredException` config has already been delivered and strict
     * mode is enabled.
     *
     * Example:
     * >> default
     * {
     *      "key": ["value", "value2"]
     * }
     *
     * >> user defined
     * {
     *      "key": ["value3"]
     * }
     *
     * >> result
     * {
     *      "key": ["value3"]
     * }
     *
     * @param string $section
     * @param array  $data
     *
     * @throws \Spiral\Core\Exception\ConfiguratorException
     * @throws \Spiral\Config\Exception\ConfigDeliveredException
     */
    public function setDefaults(string $section, array $data);

    /**
     * Modifies selected config section. Must throw `PatchDeliveredException` if modification is
     * not allowed due config has already been delivered.
     *
     * @param string         $section
     * @param PatchInterface $patch
     * @return array
     *
     * @throws \Spiral\Core\Exception\ConfiguratorException
     * @throws \Spiral\Config\Exception\ConfigDeliveredException
     */
    public function modify(string $section, PatchInterface $patch): array;
}
