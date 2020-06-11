<?php

namespace Studio;

class Studio extends Setup
{
    /**
     * Install the package assets.
     *
     * @return void
     */
    public static function install()
    {
        static::ensureDirectoriesExist();
        static::updatePackages();
        static::exportSassFiles();
        static::exportComponents();
        static::exportMixins();
        static::exportScreens();
        static::exportBaseFiles();
        static::updateWebpackConfiguration();
        static::removeNodeModules();
    }

    /**
     * Update the given package array.
     *
     * @param array $packages
     * @return array
     */
    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^4.4.0',
            'highlight.js' => '^9.18.1',
            'jquery' => '^3.4',
            'medium-zoom' => '^1.0.5',
            'moment-timezone' => '^0.5.27',
            'nprogress' => '^0.2.0',
            'popper.js' => '^1.12',
            'resolve-url-loader' => '^3.1.0',
            'sass' => '^1.24.0',
            'sass-loader' => '^8.0.0',
            'vue' => '^2.6.10',
            'vue-headful' => '^2.1.0',
            'vue-router' => '^3.1.5',
            'vue-template-compiler' => '^2.6.10',
        ] + $packages;
    }

    /**
     * Update the Sass files for the application.
     *
     * @return void
     */
    protected static function exportSassFiles()
    {
        $files = [
            '_fonts',
            '_nprogress',
            '_variables',
            'app',
        ];

        foreach ($files as $file) {
            copy(__DIR__."/../resources/sass/{$file}.scss", resource_path("sass/studio/{$file}.scss"));
        }
    }

    /**
     * Update the Vue components.
     *
     * @return void
     */
    protected static function exportComponents()
    {
        $components = [
            'FeaturedPostList',
            'Navbar',
            'PostList',
            'TaxonomyGrid',
        ];

        foreach ($components as $component) {
            copy(__DIR__."/../resources/js/components/{$component}.vue", resource_path("js/studio/components/{$component}.vue"));
        }
    }

    /**
     * Update the Vue mixins.
     *
     * @return void
     */
    protected static function exportMixins()
    {
        $mixins = [
            'HelperMixin',
            'RequestMixin',
        ];

        foreach ($mixins as $mixin) {
            copy(__DIR__."/../resources/js/mixins/{$mixin}.js", resource_path("js/studio/mixins/{$mixin}.js"));
        }
    }

    /**
     * Update the Vue screens.
     *
     * @return void
     */
    protected static function exportScreens()
    {
        $screens = [
            'HomeScreen',
            'PostScreen',
            'TagPostsScreen',
            'TagScreen',
            'TopicPostsScreen',
            'TopicScreen',
            'UserScreen',
        ];

        foreach ($screens as $screen) {
            copy(__DIR__."/../resources/js/screens/{$screen}.vue", resource_path("js/studio/screens/{$screen}.vue"));
        }
    }

    /**
     * Update the base bootstrapping files.
     *
     * @return void
     */
    protected static function exportBaseFiles()
    {
        $files = [
            'app',
            'routes',
        ];

        foreach ($files as $file) {
            copy(__DIR__."/../resources/js/{$file}.js", resource_path("js/studio/{$file}.js"));
        }
    }

    /**
     * Update the Webpack configuration.
     *
     * @return void
     */
    protected static function updateWebpackConfiguration()
    {
        file_put_contents(
            base_path('webpack.mix.js'),
            file_get_contents(__DIR__.'/../resources/stubs/webpack.stub'),
            FILE_APPEND
        );
    }
}
