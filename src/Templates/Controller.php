@php
namespace {namespace}\Controllers;
use App\Models\{! nameModel !};
use CodeIgniter\Controller;

class {! nameController !} extends Controller
{
    // show {! table !} list
    public function index(){
        ${! nameModel !} = new {! nameModel !}();
        $data = [
			'{! table !}' => ${! nameModel !}->orderBy('{! primaryKey !}', 'DESC')->paginate(10),
			'pager' => ${! nameModel !}->pager
			];
        return view('{! table !}/index', $data);
    }
	
	// add {! table !} form
    public function create(){
        return view('{! table !}/add');
    }

    // insert data
    public function store() {
		helper(['form', 'url']);
		
        $val = $this->validate([
{! fieldsVal !}
        ]);

        ${! nameModel !} = new {! nameModel !}();
        if (!$val)
        {
            echo view('{! table !}/add', [
                'validation' => $this->validator
            ]);
        }
        else
        {
        $data = [
{! fieldsDates !}
        ];
        ${! nameModel !}->insert($data);
        return $this->response->redirect(site_url('/{! table !}'));
		}
    }
	
    // show single {! table !}
    public function edit(${! primaryKey !} = null){
        ${! nameModel !} = new {! nameModel !}();
        $data['value'] = ${! nameModel !}->where('{! primaryKey !}', ${! primaryKey !})->first();
        return view('{! table !}/edit', $data);
    }
	
    // update {! table !} data
    public function update(){
        ${! nameModel !} = new {! nameModel !}();
        $id = $this->request->getVar('{! primaryKey !}');
        $data = [
{! fieldsDates !}
        ];
        ${! nameModel !}->update(${! primaryKey !}, $data);
        return $this->response->redirect(site_url('/{! table !}'));
    }
	
    // delete {! table !}
    public function delete($id = null){
        ${! nameModel !} = new {! nameModel !}();
        $data['{! table !}'] = ${! nameModel !}->where('id', ${! primaryKey !})->delete(${! primaryKey !});
        return $this->response->redirect(site_url('/{! table !}'));
    }
}