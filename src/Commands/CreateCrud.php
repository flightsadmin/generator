<?php 
namespace Flightsadmin\Generator\Commands;

use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;
use Flightsadmin\Generator\Libraries\Generate;

class CreateCrud extends BaseCommand
{
    use Generate;
    protected $group       = 'Generators';
    protected $name        = 'make:crud';
    protected $description = 'Generate complete CRUD based on database table, (External Library)';
    protected $data        = [];


    public function run(array $params)
    {
		helper('inflector');
    	$table = array_shift($params);
    	$controllerName = array_shift($params);
    	$modelName = array_shift($params);
    	$namespace = array_shift($params);

        if (empty($table))
        {
            $table = CLI::prompt('Enter Table name');
        }
        $controllerName = ucfirst($table) .'Controller';
        $modelName = ucfirst($table) .'Model';
        $namespace = "App";

        if ($fields_db =  $this->getFields($table)){
            $this->data = [
                'table'             => $table,
                'primaryKey'        => $this->getPrimaryKey($fields_db),
                'namespace'         => $namespace,
                'nameEntity'        => ucfirst($table),
                'singularTable'     => singular($table),
                'nameModel'         => ucfirst($modelName),
                'nameController'    => ucfirst($controllerName),
                'allowedFields'     => $this->getDatesFromFields($fields_db)['allowedFields'],
                'fieldsGet'         => $this->getDatesFromFields($fields_db)['fieldsGet'],
                'fieldsData'        => $this->getDatesFromFields($fields_db)['fieldsData'],
                'fieldsVal'      	=> $this->getDatesFromFields($fields_db)['fieldsVal'],
                'fieldsTh'          => $this->getDatesFromFields($fields_db)['fieldsTh'],
                'fieldsTd'          => $this->getDatesFromFields($fields_db)['fieldsTd'],
                'inputForm'         => $this->getDatesFromFields($fields_db)['inputForm'],
                'editForm'          => $this->getDatesFromFields($fields_db)['editForm'],
                'valueInput'        => $this->getDatesFromFields($fields_db)['valueInput'],
            ];

            $this->createFileCrud($this->data);
            CLI::write("Controller Generated successfully!", "cyan");
            CLI::write("Model Generated successfully!", "cyan");
            CLI::write("Views Generated successfully!", "cyan");
            CLI::write("Crud Generated successfully!", "blue");

        }else{
            CLI::write("$table Table no found", "red");
        }
    }
}