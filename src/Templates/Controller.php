@php
namespace {namespace}\Controllers;

use CodeIgniter\Controller;
use App\Models\{! nameModel !};

class {! nameController !} extends Controller
{
    protected ${! singularTable !};

    /**
     * {! nameController !} constructor.
     */
    public function __construct()
    {
        $this->{! singularTable !} = new {! nameModel !}();
    }

    public function index()
    {
        ${! table !} = $this->{! singularTable !}->findAll();
        return view('{! table !}/index', [
            '{! table !}' => ${! table !}
        ]);
    }

    public function add()
    {
        return view('{! table !}/add');
    }

    public function save()
    {
{! fieldsGet !}

        $data = [
{! fieldsData !}
        ];
        if ($this->{! singularTable !}->save($data) == false) {
            return view('{! table !}/add', [
                'errors' => $this->{! singularTable !}->errors()
            ]);
        } else {
            return redirect('{! table !}');
        }
    }

    public function edit($id)
    {
        ${! singularTable !} = $this->{! singularTable !}->find($id);
        return view('{! table !}/edit', [
            'value' => ${! singularTable !}
        ]);
    }

    public function update()
    {
            $id = $this->request->getPost('{! primaryKey !}');
{! fieldsGet !}

        $data = [
{! fieldsData !}
        ];
        $this->{! singularTable !}->update($id, $data);
        return redirect('{! table !}');
    }

    public function delete($id)
    {
        $this->{! singularTable !}->delete($id);
        return redirect('{! table !}');
    }
}