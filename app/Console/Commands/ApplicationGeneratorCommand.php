<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ApplicationGeneratorCommand extends Command
{
    protected $signature = 'generate:app';
    protected $description = 'Generate application configuration';

    protected $file, $directoryPath, $stubsToCreate, $fileName, $teamName, $appName, $dbDevUser, $dbDevPass, $dbStagUser, $dbStagPass, $dbProdUser, $dbProdPass;

    private static $deploymentLists = [
        'Develop' => 'dev-deployment',
        'Stagging' => 'stag-deployment',
        'Production' => 'prod-deployment',
    ];
    private static $directoriesPath = [
        'Develop' => 'deploy',
        'Stagging' => 'deploy',
        'Production' => 'deploy',
    ];
    private static $stubsPath = [
        'Develop' => __DIR__ . '/../../../stubs/deployment.dev.stub',
        'Stagging' => __DIR__ . '/../../../stubs/deployment.stag.stub',
        'Production' => __DIR__ . '/../../../stubs/deployment.prod.stub',
    ];

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $continue = $this->confirm('This will processed your request to generate your application configuration. Do you want to continue?');

        if ($continue) {
            $this->teamName = $this->ask('What your team name?');
            $this->appName = $this->ask('What your application name?');
            $this->dbDevUser = $this->ask('What your username database on develop?');
            $this->dbDevPass = $this->ask('What your password database on develop?');
            $this->dbStagUser = $this->ask('What your username database on stagging?');
            $this->dbStagPass = $this->ask('What your password database on stagging?');
            $this->dbProdUser = $this->ask('What your username database on production?');
            $this->dbProdPass = $this->ask('What your password database on production?');

            $this->folderFileName = $this->ask('What file and folder name do you want to create?');

            $directoryCreated = collect([]);

            $hasFailedOperation = false;
            $directoryCreated = [];
            $this->output->progressStart(count(static::$deploymentLists));
            foreach (static::$deploymentLists as $deployment => $filename) {
                $this->fileName = $filename;
                $this->stubsToCreate = $this->getStubsToCreate($deployment);
                $this->directoryPath = $this->getDirectoryPathToCreate($deployment);

                $directory = $this->getSourceFilePath();

                $this->makeDirectory(dirname($directory));

                if (!$this->files->exists($directory)) {
                    $contents = $this->getSourceFile();

                    $this->files->put($directory, $contents);
                    $directoryCreated[] = $directory;
                    $this->output->progressAdvance();
                } else {
                    $this->output->progressFinish();
                    $this->alert("File already exist detected");
                    $this->warn("File: {$directory}");

                    $hasFailedOperation = true;

                    $this->warn("");
                    $this->warn('Aborting this operation....');

                    if (count($directoryCreated) > 0) {
                        $this->output->progressStart(count($directoryCreated));
                        foreach ($directoryCreated as $directory) {
                            $this->files->delete($directory);
                            $this->output->progressAdvance();
                        }
                    } else {
                        $this->output->progressStart(1);
                        $this->output->progressAdvance();
                    }

                    $this->output->progressFinish();
                    break;
                }
            }

            if (!$hasFailedOperation) {
                $this->output->progressFinish();
                return $this->info('Success. Your application was configured. Next, you can run "php artisan generate:mvp" to create MVP feature.');
            }
        }

        return $this->warn('Aborted.');
    }

    /**
     * Get directori path each MVP to create
     *
     * @param string $directoryPath
     * @return void
     */
    private function getDirectoryPathToCreate($directoryPath)
    {
        return static::$directoriesPath[$directoryPath];
    }

    /**
     * Get source file path each MVP to create
     *
     * @param string $stubPath
     * @return void
     */
    public function getSourceFilePath()
    {
        return base_path($this->directoryPath).'/'.$this->filename.'.yaml';
    }

    /**
     * Get stubs path each MVP to create
     *
     * @param string $stubPath
     * @return void
     */
    private function getStubsToCreate($stubPath)
    {
        return static::$stubsPath[$stubPath];
    }

    /**
     * Get source stub path each MVP to create
     *
     * @return void
     */
    private function getSourceFile()
    {
        return $this->getStubContents($this->stubsToCreate, $this->getStubVariables());
    }

    /**
    **
    * Map the stub variables present in stub to its value
    *
    * @return array
    */
    private function getStubVariables()
    {
        return [
            strtolower('TEAMNAME') => $this->teamName,
            strtolower('APPNAME') => $this->appName,
            strtolower('DBDEVUSER') => $this->dbDevUser,
            strtolower('DBDEVPASS') => $this->dbDevPass,
            strtolower('DBSTAGUSER') => $this->dbStagUser,
            strtolower('DBSTAGPASS') => $this->dbStagPass,
            strtolower('DBPRODUSER') => $this->dbProdUser,
            strtolower('DBPRODPASS') => $this->dbProdPass,
        ];
    }

    /**
     * Get stubs variable and set to file stub and replace with this value
     *
     * @param string $stub
     * @param array $stubVariables
     * @return void
     */
    private function getStubContents($stub, $stubVariables = [])
    {
        $contents = file_get_contents($stub);

        foreach ($stubVariables as $search => $replace)
        {
            $contents = str_replace('{{ '.$search.' }}', $replace, $contents);
        }

        return $contents;
    }

    /**
     * Create the directory to create all MVP
     *
     * @param string $path
     * @return void
     */
    protected function makeDirectory($path)
    {
        if (! $this->files->isDirectory($path)) {
            $this->files->makeDirectory($path, 0777, true, true);
        }

        return $path;
    }
}
