<?php declare(strict_types=1);
/**
 * Spiral Framework.
 *
 * @license   MIT
 * @author    Anton Titov (Wolfy-J)
 */

namespace Spiral\Config\Loader;

use Spiral\Config\Exception\LoaderException;
use Spiral\Config\LoaderInterface;
use Spiral\Core\FactoryInterface;

class DirectoryLoader implements LoaderInterface
{
    const LOADERS = [
        'php'  => PhpLoader::class,
        'json' => JsonLoader::class,
    ];

    /** @var string */
    private $directory;

    /** @var FactoryInterface */
    private $factory;

    /** @var FileLoaderInterface[] */
    private $loaders = [];

    /**
     * @param string           $directory
     * @param FactoryInterface $factory
     */
    public function __construct(string $directory, FactoryInterface $factory)
    {
        $this->directory = rtrim($directory, '/');
        $this->factory = $factory;
    }

    /**
     * @inheritdoc
     */
    public function has(string $section): bool
    {
        foreach (static::LOADERS as $extension => $class) {
            $filename = sprintf("%s/%s.%s", $this->directory, $section, $extension);
            if (file_exists($filename)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function load(string $section): array
    {
        foreach (static::LOADERS as $extension => $class) {
            $filename = sprintf("%s/%s.%s", $this->directory, $section, $extension);
            if (!file_exists($filename)) {
                continue;
            }

            try {
                return $this->getLoader($extension)->loadFile($section, $filename);
            } catch (LoaderException $e) {
                throw new LoaderException("Unable to load config `{$section}`.", $e->getCode(), $e);
            }
        }

        throw new LoaderException("Unable to load config `{$section}`.");
    }

    /**
     * @param string $extension
     * @return FileLoaderInterface
     */
    private function getLoader(string $extension): FileLoaderInterface
    {
        if (isset($this->loaders[$extension])) {
            return $this->loaders[$extension];
        }

        return $this->loaders[$extension] = $this->factory->make(static::LOADERS[$extension]);
    }
}