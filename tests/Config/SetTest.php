<?php

/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

declare(strict_types=1);

namespace Spiral\Config\Tests;

use Spiral\Config\Patch\Set;

class SetTest extends BaseTest
{
    public function testPatch(): void
    {
        $cf = $this->getFactory();

        $this->assertEquals(['value' => 'value!'], $cf->getConfig('scope'));

        $cf->modify('scope', new Set('value', 'x'));

        $this->assertSame([
            'value' => 'x',
        ], $cf->getConfig('scope'));

        $cf->modify('scope', new Set('value', 'y'));

        $this->assertSame([
            'value' => 'y',
        ], $cf->getConfig('scope'));
    }
}
