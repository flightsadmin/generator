@php
namespace {namespace}\Controllers;

use CodeIgniter\Controller;
use App\Models\{! nameModel !};

class {! nameController !} extends BaseController
{
    public function index()
    {
        // Call view "{! singularCaps !} view"
        echo view('{! table !}/index');
    }

    // Get Single {! singularCaps !}
    public function single{! singularCaps !}(${! primaryKey !} = null)
    {
        $model = new {! nameModel !}();
        $data = $model->find(${! primaryKey !});
        return json_encode($data);
    }    

    // Get All {! singularCaps !}s
    public function get{! singularCaps !}()
    {
        $model = new {! nameModel !}();
        $data = $model->findAll();
        return json_encode($data);
    }

    // Create {! singularCaps !}
    public function create(){
        $method = $this->request->getMethod(true);
        // Insert data to database if method "POST"
        if($method == 'POST'){
            $model = new {! nameModel !}();
            $json = $this->request->getJSON();
            $data = [
{! fieldsData !}
            ];
            $model->insert($data);
        }else{
            // Call View "Add {! singularCaps !}" if method "GET"
            echo view('{! table !}/add');
        } 
    }

    // Update {! singularCaps !}
    public function update(${! primaryKey !} = null){
        $method = $this->request->getMethod(true);
        $model = new {! nameModel !}();
        // Insert data to database if method "PUT"
        if($method == 'PUT'){
            $json = $this->request->getJSON();
            $data = [
{! fieldsData !}
            ];
            $model->update(${! primaryKey !}, $data);
        }else{
            // Call View "Edit {! singularCaps !}" if method "GET"
            $data['data'] = $model->find(${! primaryKey !});
            echo view('{! table !}/edit', $data);
        } 
    }

    // Delete {! singularCaps !}
    public function delete(${! primaryKey !} = null){
        $model = new {! nameModel !}();
        $model->delete(${! primaryKey !});
    }
}