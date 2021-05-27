<?php
namespace Flightsadmin\Generator\Libraries;
use Config\Autoload;
use Config\Services;

trait Generate
{

    protected function getPathOutput($folder='', $namespace = 'App'){
        // Get namespace location form  PSR4 paths.
        $config = new Autoload();
        $location = $config->psr4[$namespace];

        $path = rtrim($location, '/') . "/". $folder;

        return rtrim($this->normalizePath($path), '/ ') .'/';
    }

    protected function normalizePath($path)
    {
        // Array to build a new path from the good parts
        $parts = [];

        // Replace backslashes with forward slashes
        $path = str_replace('\\', '/', $path);

        // Combine multiple slashes into a single slash
        $path = preg_replace('/\/+/', '/', $path);

        // Collect path segments
        $segments = explode('/', $path);

        // Initialize testing variable
        $test = '';

        foreach ($segments as $segment)
        {
            if ($segment != '.')
            {
                $test = array_pop($parts);

                if (is_null($test))
                {
                    $parts[] = $segment;
                } else if ($segment == '..')
                {
                    if ($test == '..')
                    {
                        $parts[] = $test;
                    }

                    if ($test == '..' || $test == '')
                    {
                        $parts[] = $segment;
                    }
                } else
                {
                    $parts[] = $test;
                    $parts[] = $segment;
                }
            }
        }

        return implode('/', $parts);
    }

    protected function copyFile($path, $contents = null){
        helper('filesystem');

        $folder = $this->getDirOfFile($path);
        if (! is_dir($folder))
        {
            $this->createDirectory($folder);
        }

        if (! write_file($path, $contents))
        {
            throw new \RuntimeException('Unable to create file');
        }

    }

    public function render($template_name, $data = [])
    {
        if (empty($this->parser))
        {
            $path         = realpath(__DIR__.'/../Templates/').'/';
            $this->parser = Services::parser($path);
        }

        if (is_null($this->parser))
        {
            throw new \RuntimeException('Unable to create Parser instance.');
        }
        $output = $this->parser
            ->setData($data)
            ->render($template_name);

        $output = str_replace('@php', '<?php', $output);
        $output = str_replace('!php', '?>', $output);
        $output = str_replace('@=', '<?=', $output);
        return $output;
    }

    protected function getFields($table){
        $this->db = \Config\Database::connect();
        if ($this->db->tableExists($table))
        {
            return  $fields = $this->db->getFieldData($table);
        }else{
            return false;
        }
    }

    protected function getPrimaryKey($fields)
    {
        foreach ($fields as $field) {
            if ($field->primary_key) {
                return $field->name;
            }
        }
    }

    protected function getDatesFromFields($fields){
        foreach ($fields as $field){
        if ((!$field->primary_key && $field->name !== 'created_at' && $field->name !== 'updated_at' && $field->name !== 'deleted_at')){
            $fields_th       []  =  "\t\t\t\t\t\t<th>".ucwords(str_replace('_',' ',($field->name)))."</th>";
            $fields_td       []  =  "\t\t\t\t".'rowData += `<td>${'.$field->name.'}</td>`;';
            $allowedFields   []  =  "'".$field->name."'";
            $fields_add      []  =  "\t\t\tconst " .$field->name.' = addform.'.$field->name.'.value;';
            $fields_edit     []  =  "\t\t\tconst " .$field->name.' = editform.'.$field->name.'.value;';
            $fields_data     []  =  "\t\t\t\t'" .$field->name.'\' => $json->'.$field->name.'';  
			$fields_validate []  =   $field->name.' === ""';
            $fields_value    []  =   $field->name;

            if ($this->getTypeInput($field->type)!='textarea'){
                $inputForm   []  =
			"\t\t\t".'<div class="col-md-6">
			    <label>'.ucwords(str_replace('_',' ',($field->name))).'</label> <span class="text-danger" id="' .$field->name. '"></span>
			    <input type="'.$this->getTypeInput($field->type).'" id="'.$field->name.'" class="form-control input-'.$field->name.'" placeholder="'.ucwords(str_replace('_',' ',($field->name))).'">
            </div>'; 
				$editForm   []  =
			"\t\t\t\t\t\t\t".'<div class="col-md-6">
						    <label class="form-label" for="'.$field->name.'">'.ucwords(str_replace('_',' ',($field->name))).'</label> <span class="text-danger" id="' .$field->name. '"></span>
						    <input type="'.$this->getTypeInput($field->type).'" id="'.$field->name.'" class="form-control '.$field->name.'" value="<?= esc($data[\''.$field->name.'\']); ?>">
		                </div>';
            }else{
                $inputForm   []  =
			"\t\t\t".'<div class="col-md-12">
			    <label class="form-label" for="'.$field->name.'">'.ucwords(str_replace('_',' ',($field->name))).'</label> <span class="text-danger" id="' .$field->name. '"></span>
			    <textarea name="'.$field->name.'" class="form-control" id="'.$field->name.'" placeholder="'.ucwords(str_replace('_',' ',($field->name))).'"></textarea>
            </div>';   
				$editForm   []  =
			"\t\t\t\t\t\t\t".'<div class="col-md-12">
						    <label class="form-label" for="'.$field->name.'">'.ucwords(str_replace('_',' ',($field->name))).'</label> <span class="text-danger" id="' .$field->name. '"></span>
						    <textarea name="'.$field->name.'" class="form-control" id="'.$field->name.'"><?php echo $value[\''.$field->name.'\']; ?></textarea>
		                </div>';
            }
        }
    }

        return array(
            'fieldsTh'      => implode("\n",$fields_th),
            'fieldsTd'      => implode("\n",$fields_td),
            'allowedFields' => implode(',', $allowedFields),
            'fieldsAdd'     => implode("\n", $fields_add),
            'fieldsEdit'    => implode("\n", $fields_edit),
            'fieldsData'    => implode(",\n", $fields_data),
            'fieldsValidate'=> implode(" || ", $fields_validate),
            'fieldsValue'   => implode(", ", $fields_value),
            'inputForm'     => implode("\n", $inputForm),
            'editForm'      => implode("\n", $editForm),
        );
    }

    protected function createFileCrud($data){
		$pathModel          = $this->getPathOutput('Models',$data['namespace']).$data['nameModel'].'.php';
		$pathController     = $this->getPathOutput('Controllers',$data['namespace']).$data['nameController'].'.php';
		// $pathViewadd        = $this->getPathOutput('Views',$data['namespace']).$data['table'].'/add.php';
		$pathViewedit       = $this->getPathOutput('Views',$data['namespace']).$data['table'].'/edit.php';
		$pathViewindex      = $this->getPathOutput('Views',$data['namespace']).$data['table'].'/index.php';

		$this->copyFile($pathModel,$this->render('Model',$data));
		$this->copyFile($pathController,$this->render('Controller',$data));
		// $this->copyFile($pathViewadd,$this->render('views/add',$data));
		$this->copyFile($pathViewedit,$this->render('views/edit',$data));
		$this->copyFile($pathViewindex,$this->render('views/index',$data));

		$this->createRoute($data);
    }

    /**
     * Convert the type field sql to type input html
     */
    public function getTypeInput($type_sql){
        $type_html = "";
        switch ($type_sql){
            case 'int':
                $type_html = 'number';
                break;
            case 'varchar':
                $type_html = 'text';
                break;
			case 'date':
                $type_html = 'date';
                break; 
			case 'datetime':
                $type_html = 'datetime';
                break;
			case 'timestamp':
                $type_html = 'datetime';
                break;	
			case 'time':
                $type_html = 'time';
                break;
            case 'text':
                $type_html = 'textarea';
                break;
        }
        return $type_html;
    }

    public function createRoute($data){
        $route_file = APPPATH.'Config/Routes.php';
        $string = file_get_contents($route_file);

        $data_to_write ="\n//". humanize($data['table']) ." Routes\n";
        $data_to_write.= '$routes->get(\''.$data['table'].'\',\''.$data['nameController'].'::index\');';

            if (!strpos($string, $data_to_write)) {
                file_put_contents($route_file, $data_to_write, FILE_APPEND);
            }
    }

    public function createDirectory($path, $perms = 0755)
    {
        if (is_dir($path))
        {
            return $this;
        }

        if (! mkdir($path, $perms, true))
        {
            throw new \RuntimeException(sprintf('Error creating directory', $path));
        }
        return $this;
    }

    public function getDirOfFile($file){
        $segments = explode('/', $file);
        array_pop($segments);
        return $folder = implode('/', $segments);
    }
}