<?php

declare(strict_types=1);

namespace ACTC\Core\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Str;

class CreateModule extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:module {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a new module';

    protected string $module;
    protected string $moduleSingle;

    public function handle(): void
    {
        $this->module = Str::studly(ucfirst($this->argument('name')));
        $this->moduleSingle = Str::singular($this->argument('name'));

        if (is_dir(actc_path($this->module))) {
            $this->error('Module already exists.');

            return;
        }

        $this->createStructure();

        $this->createModel();
        $this->createMigration();
        $this->createRoutesFile();
        $this->createResourceFile();
        $this->createDataFile();
        $this->createServiceProvider();

        $this->writeToApp();

        $this->info('Done!');
    }

    private function createStructure(): void
    {
        $folders = [
            'Providers',
            'Actions',
            'Data',
            'Resources',
            'routes',
        ];
        mkdir(actc_path($this->module), 0755, true);

        foreach ($folders as $folder) {
            mkdir(actc_path($this->module.'/'.$folder), 0755, true);
        }
    }

    private function createModel(): void
    {
        $this->info('Creating model');
        $input = actc_path('Core/Stubs/Module/Model.stub');
        $output = actc_path($this->module.'/'.$this->moduleSingle).'.php';
        $this->writeToFile($input, $output);
    }

    private function createMigration(): void
    {
        $this->info('Creating migration file');

        $fileName = now()->format('Y_m_d_His').'_create_'.Str::snake($this->moduleSingle).'_table.php';

        $input = actc_path('Core/Stubs/Module/Migration.stub');
        $output = database_path('migrations/'.$fileName);
        $this->writeToFile($input, $output);
    }

    private function createServiceProvider(): void
    {
        $this->info('Creating service provider');

        $fileName = $this->moduleSingle.'ServiceProvider.php';
        $input = actc_path('Core/Stubs/Module/ServiceProvider.stub');
        $output = actc_path($this->module.'/Providers/'.$fileName);
        $this->writeToFile($input, $output);
    }

    private function createRoutesFile(): void
    {
        $this->info('Creating routes file');

        $input = actc_path('Core/Stubs/Module/Routes.stub');
        $output = actc_path($this->module.'/routes/auth.php');
        $this->writeToFile($input, $output);
    }

    private function createResourceFile(): void
    {
        $this->info('Creating resource file');

        $fileName = $this->moduleSingle.'Resource.php';
        $input = actc_path('Core/Stubs/Module/Resource.stub');
        $output = actc_path($this->module.'/Resources/'.$fileName);
        $this->writeToFile($input, $output);
    }

    private function createCommandFile(): void
    {
        $this->info('Creating command file');

        $fileName = 'Fetch'.$this->moduleSingle.'.php';
        $input = actc_path('Core/Stubs/Module/Command.stub');
        $output = actc_path($this->module.'/Commands/'.$fileName);
        $this->writeToFile($input, $output);
    }

    private function createDataFile(): void
    {
        $this->info('Creating data file');

        $fileName = $this->moduleSingle.'Data.php';
        $input = actc_path('Core/Stubs/Module/Data.stub');
        $output = actc_path($this->module.'/Data/'.$fileName);
        $this->writeToFile($input, $output);
    }

    private function writeToFile(string $input, string $output): void
    {
        if (! file_exists($output)) {
            $contents = file_get_contents($input);
            $search = [
                '[Module]',
                '[ModuleCamel]',
                '[ModuleKebab]',
                '[ModuleSnake]',
                '[ModuleSingle]',
                '[ModuleSingleCamel]',
                '[ModuleSingleKebab]',
                '[ModuleSingleSnake]',
                '[ModulePlural]',
                '[ModulePluralCamel]',
                '[ModulePluralKebab]',
                '[ModulePluralSnake]',
            ];
            $replace = [
                $this->module,
                Str::camel($this->module),
                Str::kebab($this->module),
                Str::snake($this->module),
                $this->moduleSingle,
                Str::camel($this->moduleSingle),
                Str::kebab($this->moduleSingle),
                Str::snake($this->moduleSingle),
                Str::plural($this->moduleSingle),
                Str::camel(Str::plural($this->moduleSingle)),
                Str::kebab(Str::plural($this->moduleSingle)),
                Str::snake(Str::plural($this->moduleSingle)),
            ];

            file_put_contents($output, str_replace($search, $replace, $contents));
        }
    }

    private function writeToApp(): void
    {
        $appFile = actc_path('Core/Providers/CoreServiceProvider.php');

        // get the contents of the file
        $appData = file_get_contents($appFile);
        $name = $this->moduleSingle.'ServiceProvider';
        $provider = 'ACTC\\'.$this->module.'\Providers\\'.$name;

        // @PHP-CS-Fixer (disable_next_line)
        $replaceProvider = "// register the service providers\n\t\t\$this->app->register(".$name.'::class);';

        $search = [
            'use Illuminate\Support\ServiceProvider;',
            '// register the service providers',
        ];
        $replace = [
            'use '.$provider.";\nuse Illuminate\\Support\\ServiceProvider;",
            $replaceProvider,
        ];

        $appData = str_replace($search, $replace, $appData);

        file_put_contents($appFile, $appData);
    }
}
