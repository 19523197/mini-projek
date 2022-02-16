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
        'Resource',
        'Request',
        'Service',
        'Repository',
        'RepositoryContract',
        'DomainModel',
        'ValueObject',
    ];
    private static $directoriesPath = [
        'Controller' => 'app/Http/Controllers',
        'Resource' => 'app/Http/Resources',
        'Request' => 'app/Http/Requests',
        'Service' => 'app/Services',
        'Repository' => 'app/Repositories',
        'RepositoryContract' => 'app/Repositories/Contracts',
        'DomainModel' => 'app/DomainModel',
        'ValueObject' => 'app/ValueObject',
    ];
    private static $nameSpacesPath = [
        'Controller' => 'App\Http\Controllers',
        'Resource' => 'App\Http\Resources',
        'Request' => 'App\Http\Requests',
        'Service' => 'App\Services',
        'Repository' => 'App\Repositories',
        'RepositoryContract' => 'App\Repositories\Contracts',
        'DomainModel' => 'App\DomainModel',
        'ValueObject' => 'App\ValueObject',
    ];
    private static $stubsPath = [
        'Controller' => __DIR__ . '/../../../uiigateway/controller.bsi',
        'Resource' => __DIR__ . '/../../../uiigateway/resource.bsi',
        'Request' => __DIR__ . '/../../../uiigateway/request.bsi',
        'Service' => __DIR__ . '/../../../uiigateway/service.bsi',
        'Repository' => __DIR__ . '/../../../uiigateway/repository.bsi',
        'RepositoryContract' => __DIR__ . '/../../../uiigateway/repository.contract.bsi',
        'DomainModel' => __DIR__ . '/../../../uiigateway/domain.model.bsi',
        'ValueObject' => __DIR__ . '/../../../uiigateway/value.object.bsi',
    ];
    private static $routesPath = __DIR__ . '/../../../routes/web.php';
    private static $routesFindToPrepend = [
        'Public' => "}); // END_OF_PUBLIC_API_LINE (DONT DELETE THIS)",
        'Private' => "}); // END_OF_PRIVATE_API_LINE (DONT DELETE THIS)"
    ];
    private static $routesPackage = [
        'NewLineEnd' => "",
        'Destroy' => "    \$router->delete('/destroy/{uuid}', ",
        'Update' => "    \$router->put('/update', ",
        'Create' => "    \$router->post('/create', ",
        'Show' => "    \$router->get('/show/{uuid}', ",
        'Index' => "    \$router->get('/index', ",
        'CommentRoute' => '    // Routes for ',
        'NewLineStart' => "",
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
            $this->folderFileName = $this->ask('What file and folder name do you want to create? (Write with CamelCase)');
            $this->publicOrPrivateApi = $this->choice('Is API used for PUBLIC or PRIVATE?', ['PUBLIC', 'PRIVATE']);

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

                $routesFind = static::$routesFindToPrepend[ucwords(strtolower($this->publicOrPrivateApi))];

                $contents = file(static::$routesPath, FILE_IGNORE_NEW_LINES);
                if ($index = array_search($routesFind, $contents)) {
                    $indexOfArrayRoute = $index;

                    foreach (static::$routesPackage as $key => $route) {
                        if ($key == 'CommentRoute') {
                            $route = $route.' '.$this->folderFileName;
                        } else if ($key !== 'NewLineStart' && $key !== 'NewLineEnd') {
                            $route = $route."'".$this->folderFileName."\\".$this->folderFileName."@".strtolower($key)."');";
                        }
                        array_splice($contents, $indexOfArrayRoute, 0, $route);
                    }

                    $temp = implode("\n", $contents);
                    file_put_contents(static::$routesPath, $temp);
                }

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
            strtolower('CLASSNAME') => $this->getSingularClassName($this->folderFileName),
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
