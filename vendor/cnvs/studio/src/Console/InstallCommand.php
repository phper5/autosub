<?php

namespace Studio\Console;

use Illuminate\Console\Command;
use Studio\Studio;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'studio:install {--force : Overwrite existing views by default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold the frontend for Canvas';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [
        'app.stub' => 'studio/app.blade.php',
    ];

    /**
     * The controllers that need to be exported.
     *
     * @var array
     */
    protected $controllers = [
        'BaseController.stub' => 'Http/Controllers/Studio/BaseController.php',
        'PostController.stub' => 'Http/Controllers/Studio/PostController.php',
        'TagController.stub' => 'Http/Controllers/Studio/TagController.php',
        'TopicController.stub' => 'Http/Controllers/Studio/TopicController.php',
        'UserController.stub' => 'Http/Controllers/Studio/UserController.php',
        'ViewController.stub' => 'Http/Controllers/Studio/ViewController.php',
    ];

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->ensureDirectoriesExist();
        $this->exportViews();
        $this->exportBackend();

        Studio::install();

        $this->callSilent('vendor:publish', ['--tag' => 'studio-config']);

        $this->info('Installation complete.');
        $this->comment('Please run "npm install && npm run dev" to compile your fresh scaffolding.');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function ensureDirectoriesExist()
    {
        if (! is_dir($directory = $this->getViewPath('studio'))) {
            mkdir($directory, 0755, true);
        }

        if (! is_dir($directory = app_path('Http/Controllers/Studio'))) {
            mkdir($directory, 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        foreach ($this->views as $key => $value) {
            if (file_exists($view = $this->getViewPath($value)) && ! $this->option('force')) {
                if (! $this->confirm("The [{$value}] view already exists. Do you want to replace it?")) {
                    continue;
                }
            }

            copy(dirname(__DIR__, 2)."/resources/stubs/views/{$key}", $view);
        }
    }

    /**
     * Export the backend controllers and routes.
     *
     * @return void
     */
    protected function exportBackend()
    {
        foreach ($this->controllers as $key => $value) {
            file_put_contents(
                app_path($value),
                str_replace(
                    '{{namespace}}',
                    $this->laravel->getNamespace(),
                    file_get_contents(__DIR__."/../../resources/stubs/controllers/{$key}")
                )
            );
        }

        file_put_contents(
            base_path('routes/web.php'),
            file_get_contents(__DIR__.'/../../resources/stubs/routes.stub'),
            FILE_APPEND
        );
    }

    /**
     * Get full view path relative to the application's configured view path.
     *
     * @param string $path
     * @return string
     */
    protected function getViewPath($path)
    {
        return implode(DIRECTORY_SEPARATOR, [
            config('view.paths')[0] ?? resource_path('views'), $path,
        ]);
    }
}
