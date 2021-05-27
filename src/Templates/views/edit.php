@= $this->extend('layouts/default') !php
@= $this->section('content') !php
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Update {! singularCaps !}</h5>
                        <a class="btn btn-secondary btn-sm" href="@= site_url('/{! table !}') !php"><i class="bi bi-arrow-left"></i> Back</a> 
                    </div>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                	    <form class="row g-2" id="edit{! singularCaps !}">
{! editForm !}
                	        <div class="col-md-12 d-flex justify-content-between align-items-center">
                	            <!-- Input Hidden ID -->
                	            <input type="hidden" name="{! singularLower !}{! primaryKey !}" value="@= esc($data['{! primaryKey !}']) !php">
                                <p></p>
                	            <button class="btn btn-primary btn-sm float-right">UPDATE</button>
                	        </div>
                	    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const editform = document.getElementById('edit{! singularCaps !}');

    // update product to database
    editform.addEventListener('submit', async (e) => {
            e.preventDefault();
            
        	const {! primaryKey !} = editform.{! singularLower !}{! primaryKey !}.value;
{! fieldsEdit !}
        try {
            await fetch(`/{! singularLower !}/update/${{! primaryKey !}}`, {
                method: "PUT",
                body: JSON.stringify({{! fieldsValue !}}),
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
</script>
@= $this->endSection() !php