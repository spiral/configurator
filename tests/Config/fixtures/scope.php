<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

return [
    'value' => \Spiral\Core\ContainerScope::getContainer()->get(\Spiral\Config\Tests\Value::class)->getValue()
];
