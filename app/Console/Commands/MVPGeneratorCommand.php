<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Pluralizer;
use Illuminate\Filesystem\Filesystem;

class MVPGeneratorCommand extends Command
{
    protected $signature = 'generate:mvp';
    protected $description = 'Generate new MVP feature';
    protected $file, $teamName, $appName, $folderFileName, $directoryPath, $stubsToCreate, $nameSpacesToCreate, $lastPrefixToCreate;
    private static $lastPrefixWantsToCreate = [
        'Controller',
    ];
    private static $directoriesPath = [
        'Controller' => 'app/Http/Controllers',
    ];
    private static $nameSpacesPath = [
        'Controller' => 'App\Http\Controllers',
    ];
    private static $stubsPath = [
        'Controller' => __DIR__ . '/../../../stubs/controller.stub',
    ];

    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function handle()
    {
        $continue = $this->confirm('This will processed your request to create new MVP. Do you want to continue?');

        if ($continue) {
            $this->teamName = strtolower($this->ask('What your team name?'));
            $this->appName = $this->ask('What application name do you want to create?');
            $this->folderFileName = $this->ask('What file and folder name do you want to create?');

            $directoryCreated = collect([]);

            $hasFailedOperation = false;
            $directoryCreated = [];
            $this->output->progressStart(count(static::$lastPrefixWantsToCreate));
            foreach (static::$lastPrefixWantsToCreate as $toCreate) {
                $this->lastPrefixToCreate = $toCreate;
                $this->stubsToCreate = $this->getStubsToCreate($toCreate);
                $this->nameSpacesToCreate = $this->getNameSpaceToCreate($toCreate);
                $this->directoryPath = $this->getDirectoryPathToCreate($toCreate);

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
                return $this->info('Success. All '.$this->folderFileName.' MVP was created!');
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
     * Get namespace path each MVP to create
     *
     * @param string $nameSpacePath
     * @return void
     */
    private function getNameSpaceToCreate($nameSpacePath)
    {
        return static::$nameSpacesPath[$nameSpacePath].'\\'.$this->folderFileName;
    }

    /**
     * Get source file path each MVP to create
     *
     * @param string $stubPath
     * @return void
     */
    public function getSourceFilePath()
    {
        return base_path($this->directoryPath).'/'.$this->folderFileName.'/'.$this->getSingularClassName($this->folderFileName).''.$this->lastPrefixToCreate.'.php';
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
            strtolower('NAMESPACE') => $this->nameSpacesToCreate,
            strtolower('CLASS') => $this->getSingularClassName($this->folderFileName),
        ];
    }

    /**
     * Make the folder and file name to singular (1 words)
     *
     * @return void
     */
    private function getSingularClassName($name)
    {
        return ucwords(Pluralizer::singular($name));
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
