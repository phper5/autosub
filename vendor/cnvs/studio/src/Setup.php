<?php

namespace Studio;

use Illuminate\Filesystem\Filesystem;

class Setup
{
    /**
     * Ensure the component directories we need exist.
     *
     * @return void
     */
    protected static function ensureDirectoriesExist()
    {
        $filesystem = new Filesystem;

        $directoryPaths = [
            'js/studio',
            'js/studio/components',
            'js/studio/mixins',
            'js/studio/screens',
            'sass/studio',
        ];

        foreach ($directoryPaths as $path) {
            if (! $filesystem->isDirectory($directory = resource_path($path))) {
                $filesystem->makeDirectory($directory, 0755, true);
            }
        }
    }

    /**
     * Update the "package.json" file.
     *
     * @param bool $dev
     * @return void
     */
    protected static function updatePackages($dev = true)
    {
        if (! file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = static::updatePackageArray(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }

    /**
     * Remove the installed Node modules.
     *
     * @return void
     */
    protected static function removeNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
        });
    }
}
