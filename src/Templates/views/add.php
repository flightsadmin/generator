@= $this->extend('layouts/default') !php
@= $this->section('content') !php
<div class="container mt-2">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card card-default">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5>Update {! singularCaps !}</h5>
                        <a class="btn btn-secondary btn-sm" href="/{! singularLower !}"><i class="bi bi-arrow-left"></i> Back</a> 
                    </div>
                </div>
                <div class="card-body">                 
                    <div class="col-md-12">
                	    <form class="row g-2" id="add{! singularCaps !}">
{! inputForm !}
                			<div class="col-md-12 d-flex justify-content-between align-items-center">
                	            <button type="reset" class="btn btn-secondary btn-sm">Reset</button>
                	            <button type="submit" class="btn btn-primary btn-sm">Save</button>
                	        </div>
                	    </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const form = document.getElementById('add{! singularCaps !}');
    
    // save product to database 
    form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
{! fieldsConst !}

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

</script>   
@= $this->endSection() !php