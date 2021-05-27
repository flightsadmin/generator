<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>
<div class="container-fluid mt-2">
    <div class="row justify-contents-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item bi bi-house-fill"><a href="/product"> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Product</li>
                  </ol>
                </nav>
                <a class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#addProductModal"><i class="bi bi-plus-lg"></i> Add Product</a>
            </div>
		    <!-- Product List Table -->
			<table class="table table-bordered table-sm">
				<thead>
	            	<tr>
						<th>Name</th>
						<th>Price</th>
						<th width=12%>Actions</th>
	            	</tr>
	        	</thead>
	            <tbody>                            
	            </tbody>    
	    	</table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductLabel">Add Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-2" id="addProductForm">
			<div class="col-md-6">
			    <label>Name</label> <span class="text-danger" id="name"></span>
			    <input type="text" id="name" class="form-control" placeholder="Name">
            </div>
			<div class="col-md-6">
			    <label>Price</label> <span class="text-danger" id="price"></span>
			    <input type="text" id="price" class="form-control" placeholder="Price">
            </div>
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editProductModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editProductLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="productLabel">Edit Product</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-2" id="editProductForm">
            <input type="hidden" id="id" class="input-id">
            <div class="col-md-6">
                <label>Name</label> <span class="text-danger" id="name"></span>
                <input type="text" id="name" class="form-control input-name" placeholder="Name">
            </div>
            <div class="col-md-6">
                <label>Price</label> <span class="text-danger" id="price"></span>
                <input type="text" id="price" class="form-control input-price" placeholder="Price">
            </div>
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm btnSave">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    // Initialize page and load Products
    document.addEventListener('DOMContentLoaded', () => {
        // Call function showData on loaded content
        showData();
    });
    // Show Products from database
    const showData = async () => {
        try {
            const response = await fetch('/product/getProduct', {
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            const data = await response.json();
            
            const table = document.querySelector('table tbody');
            let rowData = "";
            data.forEach(({ id, name, price }) => {
                rowData += `<tr>`;
				rowData += `<td>${name}</td>`;
				rowData += `<td>${price}</td>`;
                rowData += `<td>`;
                rowData += `<a class="btn btn-info btn-sm btn-edit bi bi-pencil" data-id="${id}" data-name="${name}" data-price="${price}"></a>`;
                rowData += `<a class="btn btn-danger btn-sm deleteBtn bi bi-trash-fill" data-id="${id}"></a>`;
                rowData += `</td>`;
                rowData += `</tr>`;
            });
            table.innerHTML = rowData;
        } catch (err) {
            console.log(err);
        }
    }

    const sendHttpRequest = (method, url, data) => {
        return fetch(url, {
            method: method,
            body: JSON.stringify(data),
            headers: {
                "Content-Type": "application/json",
                "X-Requested-With": "XMLHttpRequest"
            }
        })
            .then(response => response.json());
    }

    // Add Product to database
    const addform = document.getElementById('addProductForm');
    addform.addEventListener('submit', async (e) => {
            e.preventDefault();
			const name = addform.name.value;
			const price = addform.price.value;
            try {
                await fetch('/product/create', {
                    method: "POST",
                    body: JSON.stringify({ name, price }),
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                }); 
               location.assign('/product');
            } catch (err) {
                console.log(err);
        }
    });

    // Edit Data
    document.addEventListener('click', async function (e) {
        if (!e.target.classList.contains('btn-edit')) {
            return;
        }
            const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
            const id = e.target.dataset.id;
            const name = document.querySelector('.input-name');
            const price = document.querySelector('.input-price');
            
            fetch(`http://localhost:8080/product/singleProduct/${id}`)
            .then(res => res.json())
            .then(data => {
                id.value = data.id;
                name.value = data.name;
                price.value = data.price;
                modal.show();  

            })
                .catch(err => console.log(err));
    });
        const btnSave = document.querySelector('.btnSave');
        btnSave.addEventListener('click', function (e) {
        e.preventDefault();

            const data = {
                id: document.getElementById('id').innerHTML,
                name: document.getElementById('name').innerHTML,
                email: document.getElementById('price').innerHTML,
            };
            updateData(data);
    });
    const updateData = data => {
        const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
        sendHttpRequest('PUT', 'http://localhost:8080/product', data).then(result => {
            closeModal();
            showData();
            modal.hide();
        });
    }
    // Delete product method
    document.querySelector('table tbody').addEventListener('click', async (event) => {
    const id = event.target.dataset.id;

    if (!event.target.classList.contains("deleteBtn")) {
      return;
    }
        if (confirm('Are you sure to delete this Product?')) {
            try {
                await fetch(`/product/delete/${id}`, {
                    method: "DELETE",
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                }); 
                showData();
            } catch (err) {
                console.log(err);
            }
        }
    });
</script>
<?= $this->endSection() ?>