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
            $table = CLI::prompt('Table name');
        }

		if (empty($controller))
        {
            $controllerName = ucfirst($table) .'Controller';
        }

        if (empty($modelName))
        {
            $modelName = ucfirst($table) .'Model';
        }
		
        if ($modelName==$controllerName){
            $modelName = CLI::prompt('Please enter other name for Model');
        }
		
        if (empty($namespace))
        {
            $namespace = "App";
        }

        if ($fields_db =  $this->getFields($table)){
            $this->data = [
                'table'             => $table,
                'primaryKey'        => $this->getPrimaryKey($fields_db),
                'namespace'         => $namespace,
                'nameEntity'        => ucfirst($table),
                'nameModel'         => ucfirst($modelName),
                'nameController'    => ucfirst($controllerName),
                'propertyList'      => $this->getDatesFromFields($fields_db)['propertyList'],
                'allowedFields'     => $this->getDatesFromFields($fields_db)['allowedFields'],
                'fieldsDates'       => $this->getDatesFromFields($fields_db)['fieldsDates'],
                'fieldsVal'      	=> $this->getDatesFromFields($fields_db)['fieldsVal'],
                'fieldsTh'          => $this->getDatesFromFields($fields_db)['fieldsTh'],
                'fieldsTd'          => $this->getDatesFromFields($fields_db)['fieldsTd'],
                'inputForm'         => $this->getDatesFromFields($fields_db)['inputForm'],
                'editForm'          => $this->getDatesFromFields($fields_db)['editForm'],
                'valueInput'        => $this->getDatesFromFields($fields_db)['valueInput'],
            ];

            $this->createFileCrud($this->data);
            
            echo "Crud Generated successfully!";

        }else{
            echo "Table no found";
        }
    }
}