<?php

namespace Flightsadmin\Generator\Commands;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Config\Database;

class Install extends BaseCommand
{

	protected $group = 'Generators';
	protected $name = 'generator:install';
	protected $description = 'Install the module';
	protected $usage = 'generator:install';

	public function run(array $params)
	{
		try {
			$this->copyResources();			
			$this->updateRoute();
			$this->updateFilters();
			$this->updateValidation();

			if (CLI::prompt('Run npm install?', ['y', 'n']) == 'y')
				{
					CLI::write("Installing dependancies");
					exec('npm install');
				}

			CLI::write("Module have been installed");
		} catch (\Exception  $e) {
			$this->showError($e);
		}
	}

	private function updateFilters()
	{
		CLI::write("Updating Filters file",'blue');
			$filtersFile = APPPATH.'Config/Filters.php';
	        $filtersContents = file_get_contents($filtersFile);
	        $filtersItemStub = "\t\t'auth' 		=> \App\Filters\Auth::class, \n\t\t'noauth' 	=> \App\Filters\Noauth::class, \n\t\t'userscheck' => \App\Filters\UsersCheck::class,";
			$filtersItemHook = 'public $aliases = [';

			if (!strpos($filtersContents, $filtersItemStub)) {
	            $newContents = str_replace($filtersItemHook, $filtersItemHook . PHP_EOL . $filtersItemStub, $filtersContents);

	            file_put_contents($filtersFile, $newContents);
	        } 		
        CLI::write("Filter file updated successfully",'green');
	}

	private function updateValidation()
	{
		CLI::write("Updating Validation file",'blue');
			$validationFile = APPPATH.'Config/Validation.php';
	        $validationContents = file_get_contents($validationFile);
	        $validationItemStub = "\t\t\App\Validation\UserRules::class,";
			$validationItemHook = 'public $ruleSets = [';

			if (!strpos($validationContents, $validationItemStub)) {
	            $newContents = str_replace($validationItemHook, $validationItemHook . PHP_EOL . $validationItemStub, $validationContents);

	            file_put_contents($validationFile, $newContents);
	        } 		
        CLI::write("Validation file updated successfully",'green');
	}

	private function updateRoute()
	{
		CLI::write("Updating route file",'blue');
			$routeFile = APPPATH.'Config/Routes.php';
			$string = file_get_contents($routeFile);

			$data_to_write ="\n //Custom Routes Added during installation \n";
			$data_to_write.= '$routes->get(\'/\', \'Users::index\', [\'filter\' => \'noauth\']);';
	        $data_to_write.="\n"; 
	        $data_to_write.= '$routes->get(\'logout\', \'Users::logout\');';
	        $data_to_write.="\n"; 
	        $data_to_write.= '$routes->match([\'get\',\'post\'],\'register\', \'Users::register\', [\'filter\' => \'noauth\']);';
	        $data_to_write.="\n"; 
	        $data_to_write.= '$routes->match([\'get\',\'post\'],\'profile\', \'Users::profile\', [\'filter\' => \'auth\']);';
	        $data_to_write.="\n";
	        $data_to_write.= '$routes->get(\'dashboard\', \'Dashboard::index\', [\'filter\' => \'auth\']);';

	        if (!strpos($string, $data_to_write)) {
				file_put_contents($routeFile, $data_to_write, FILE_APPEND);
			}
        CLI::write("Route file updated successfully",'green');
	}

	private function copyResources()
	{
		CLI::write("Copying assest to public directory", 'blue');
		$sourcePath = realpath(__DIR__ . "/../Install");
		$destPath = realpath(ROOTPATH);

		$this->copy($sourcePath, $destPath, ["mix-manifest.json"]);
		CLI::write("Asset files copied successfully",'green');
	}

	public function copy($source, $target, $skipFiles = [])
	{
		if (!is_dir($source)) {
			return copy($source, $target);
		}

		$it = new RecursiveDirectoryIterator($source, RecursiveDirectoryIterator::SKIP_DOTS);
		$ri = new RecursiveIteratorIterator($it, RecursiveIteratorIterator::SELF_FIRST);
		$this->ensureDirectoryExists($target);

		$result = true;
		/** @var RecursiveDirectoryIterator $ri */
		foreach ($ri as $file) {

			$fileName = $file->getFilename();

			$skip = false;
			foreach ($skipFiles as $skipFile) {
				if (strcasecmp($skipFile, $fileName) == 0) {
					$skip = true;
				}
			}

			if ($skip) {
				continue;
			}

			$targetPath = $target . DIRECTORY_SEPARATOR . $ri->getSubPathName();
			if ($file->isDir()) {
				$this->ensureDirectoryExists($targetPath);
			} else {
				$result = $result && copy($file->getPathname(), $targetPath);
			}
		}

		return $result;
	}

	public function ensureDirectoryExists($directory)
	{
		if (!is_dir($directory)) {
			if (file_exists($directory)) {
				throw new \RuntimeException(
					$directory . ' exists and is not a directory.'
				);
			}
			if (!@mkdir($directory, 0777, true)) {
				throw new \RuntimeException(
					$directory . ' does not exist and could not be created.'
				);
			}
		}
	}
}
