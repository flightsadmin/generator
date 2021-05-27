@= $this->extend('layouts/default') !php
@= $this->section('content') !php
<div class="container-fluid mt-2">
    <div class="row justify-contents-center">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item bi bi-house-fill"><a href="/{! singularLower !}"> Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{! singularCaps !}</li>
                  </ol>
                </nav>
                <a class="btn btn-success btn-sm btn-add-{! singularLower !}" data-bs-toggle="modal" data-bs-target="#add{! singularCaps !}Modal"><i class="bi bi-plus-lg"></i> Add {! singularCaps !}</a>
            </div>
		    <!-- Product List Table -->
			<table class="table table-bordered table-sm">
				<thead>
	            	<tr>
{! fieldsTh !}
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
<div class="modal fade" id="add{! singularCaps !}Modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="{! singularLower !}Label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="{! singularLower !}Label">Add {! singularCaps !}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-2" id="add{! singularCaps !}">
            <input type="hidden" class="{! primaryKey !}">
{! inputForm !}
            <div class="col-md-12 d-flex justify-content-between align-items-center">
                <button type="button" class="btn btn-secondary btn-sm"  data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    // Initialize page and load {! singularCaps !}s
    document.addEventListener('DOMContentLoaded', () => {
        // Call function showData on loaded content
        showData();
    });
    // Show {! singularCaps !}s from database
    const showData = async () => {
        try {
            const response = await fetch('/{! singularLower !}/get{! singularCaps !}', {
                headers: {
                    "Content-Type": "application/json",
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            const data = await response.json();
            
            const table = document.querySelector('table tbody');
            let rowData = "";
            data.forEach(({ {! primaryKey !}, {! fieldsValue !} }) => {
                rowData += `<tr>`;
{! fieldsTd !}
                rowData += `<td>`;
                rowData += `<a href="/{! singularLower !}/update/${{! primaryKey !}}" class="btn btn-info btn-sm bi bi-pencil"></a>`;
                rowData += `<a class="btn btn-danger btn-sm deleteBtn bi bi-trash-fill" data-id="${{! primaryKey !}}"></a>`;
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

    // Add {! singularCaps !} to database
    const addform = document.getElementById('add{! singularCaps !}');
    addform.addEventListener('submit', async (e) => {
            e.preventDefault();
{! fieldsAdd !}

            try {
                await fetch('/{! singularLower !}/create', {
                    method: "POST",
                    body: JSON.stringify({ {! fieldsValue !} }),
                    headers: {
                        "Content-Type": "application/json",
                        "X-Requested-With": "XMLHttpRequest"
                    }
                }); 
               location.assign('/{! singularLower !}');
            } catch (err) {
                console.log(err);
        }
    });

    // Delete {! singularLower !} method
    document.querySelector('table tbody').addEventListener('click', async (event) => {
    const {! primaryKey !} = event.target.dataset.id;

    if (!event.target.classList.contains("deleteBtn")) {
      return;
    }
        if (confirm('Are you sure to delete this {! singularCaps !}?')) {
            try {
                await fetch(`/{! singularLower !}/delete/${{! primaryKey !}}`, {
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
@= $this->endSection() !php