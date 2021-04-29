<?php 
namespace Flightsadmin\Generator\Commands;

use Config\Autoload;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class Publish extends BaseCommand
{
    protected $group = 'Generators';

    protected $name = 'install';

    protected $description = 'Publish Selected Files and folders to Admin Panelin the current application.';

    protected $usage = 'install';

    protected $arguments = [];

    /**
     * the Command's Options
     * @var array
     */
    protected $options = [
        '-f'    => 'Force overwrite ALL existing files in destination',
    ];

    /**
     * The path to Myth\Auth\src directory.
     *
     * @var string
     */
    protected $sourcePath;

    /**
     * Whether the Views were published for local use.
     * @var bool
     */
    protected $viewsPublished = false;

    //--------------------------------------------------------------------

    /**
     * Displays the help for the spark cli script itself.
     *
     * @param array $params
     */
    public function run(array $params)
    {
        $this->determineSourcePath();

        // Migration
        if (CLI::prompt('Publish Migration?', ['y', 'n']) == 'y')
        {
            $this->publishMigration();
        }

        // Models
        if (CLI::prompt('Publish Models?', ['y', 'n']) == 'y')
        {
            $this->publishModels();
        }

        // Controller
        if (CLI::prompt('Publish Controller?', ['y', 'n']) == 'y')
        {
            $this->publishController();
        }

        // Views
        if (CLI::prompt('Publish Views?', ['y', 'n']) == 'y')
        {
            $this->publishViews();
            $this->viewsPublished = true;
        }

        // Filters
        if (CLI::prompt('Publish Filters?', ['y', 'n']) == 'y')
        {
            $this->publishFilters();
        }

        // Config
        if (CLI::prompt('Publish Config file?', ['y', 'n']) == 'y')
        {
            $this->publishConfig();
        }
    }

    protected function publishModels()
    {
        $models = ['UserModel'];

        foreach ($models as $model)
        {
            $path = "{$this->sourcePath}/Install/Models/{$model}.php";

            $content = file_get_contents($path);
            $content = $this->replaceNamespace($content, 'Flightsadmin\Generator\Install\Models', 'Models');

            $this->writeFile("Models/{$model}.php", $content);
        }
    }

    protected function publishController()
    {
        $controllers = ['Dashboard', 'Login', 'Register'];

        foreach ($controllers as $controller) 
        {
            $path = "{$this->sourcePath}/Install/Controllers/{$controller}.php";

            $content = file_get_contents($path);
            $content = $this->replaceNamespace($content, 'Flightsadmin\Generator\Install\Controllers', 'Controllers');

            $this->writeFile("Controllers/{$controller}.php", $content);           
        }

    }

    protected function publishViews()
    {
        $map = directory_map($this->sourcePath . '/Install/Views');
        $prefix = '';

        foreach ($map as $key => $view)
        {
            if (is_array($view))
            {
                $oldPrefix = $prefix;
                $prefix .= $key;

                foreach ($view as $file)
                {
                    $this->publishView($file, $prefix);
                }

                $prefix = $oldPrefix;

                continue;
            }

            $this->publishView($view, $prefix);
        }
    }

    protected function publishView($view, string $prefix = '')
    {
        $path = "{$this->sourcePath}/Install/Views/{$prefix}{$view}";
		$namespace = defined('APP_NAMESPACE') ? APP_NAMESPACE : 'App';

        $content = file_get_contents($path);
        $content = str_replace('Flightsadmin\Generator\Install\Views', $namespace.'\Auth', $content);

        $this->writeFile("Views/Auth/{$prefix}{$view}", $content);
    }

    protected function publishFilters()
    {
        $filters = ['LoginFilter', 'PermissionFilter', 'RoleFilter'];

        foreach ($filters as $filter)
        {
            $path = "{$this->sourcePath}/Install/Filters/{$filter}.php";

            $content = file_get_contents($path);
            $content = $this->replaceNamespace($content, 'Flightsadmin\Generator\Install\Filters', 'Filters');

            $this->writeFile("Filters/{$filter}.php", $content);
        }
    }

    protected function publishMigration()
    {
        $map = directory_map($this->sourcePath . '/Install/Database/Migrations');

        foreach ($map as $file)
        {
            $content = file_get_contents("{$this->sourcePath}/Install/Database/Migrations/{$file}");
            $content = $this->replaceNamespace($content, 'Flightsadmin\Generator\Install\Database\Migrations', 'Database\Migrations');

            $this->writeFile("Database/Migrations/{$file}", $content);
        }

        CLI::write('  Remember to run `spark migrate -all` to migrate the database.', 'blue');
    }

    protected function publishConfig()
    {
        $path = "{$this->sourcePath}/Install/Config/Auth.php";

        $content = file_get_contents($path);
        $content = str_replace('namespace Flightsadmin\Generator\Install\Config', "namespace Config", $content);
        $content = str_replace("use CodeIgniter\Config\BaseConfig;\n", '', $content);
        $content = str_replace('extends BaseConfig', "extends \Flightsadmin\Generator\Install\Config\Auth", $content);

        // are we also changing the views?
        if ($this->viewsPublished)
        {
            $namespace = defined('APP_NAMESPACE') ? APP_NAMESPACE : 'App';
            $content = str_replace('Flightsadmin\Generator\Install\Views', $namespace . '\Views', $content);
        }

        $this->writeFile("Config/Auth.php", $content);
    }

    //--------------------------------------------------------------------
    // Utilities
    //--------------------------------------------------------------------

    /**
     * Replaces the Myth\Auth namespace in the published
     * file with the applications current namespace.
     *
     * @param string $contents
     * @param string $originalNamespace
     * @param string $newNamespace
     *
     * @return string
     */
    protected function replaceNamespace(string $contents, string $originalNamespace, string $newNamespace): string
    {
        $appNamespace = APP_NAMESPACE;
        $originalNamespace = "namespace {$originalNamespace}";
        $newNamespace = "namespace {$appNamespace}\\{$newNamespace}";

        return str_replace($originalNamespace, $newNamespace, $contents);
    }

    /**
     * Determines the current source path from which all other files are located.
     */
    protected function determineSourcePath()
    {
        $this->sourcePath = realpath(__DIR__ . '/../');

        if ($this->sourcePath == '/' || empty($this->sourcePath))
        {
            CLI::error('Unable to determine the correct source directory. Bailing.');
            exit();
        }
    }

    /**
     * Write a file, catching any exceptions and showing a
     * nicely formatted error.
     *
     * @param string $path
     * @param string $content
     */
    protected function writeFile(string $path, string $content)
    {
        $config = new Autoload();
        $appPath = $config->psr4[APP_NAMESPACE];

        $filename = $appPath . $path;
        $directory = dirname($filename);

        if (! is_dir($directory))
        {
            mkdir($directory, 0777, true);
        }

        if (file_exists($filename))
        {
            $overwrite = (bool) CLI::getOption('f');

            if (! $overwrite && CLI::prompt("  File '{$path}' already exists in destination. Overwrite?", ['n', 'y']) === 'n')
            {
                CLI::error("  Skipped {$path}. If you wish to overwrite, please use the '-f' option or reply 'y' to the prompt.");
                return;
            }
        }

        if (write_file($filename, $content))
        {
            CLI::write(CLI::color('  Created: ', 'green') . $path);
        }
        else
        {
            CLI::error("  Error creating {$path}.");
        }
    }
}
