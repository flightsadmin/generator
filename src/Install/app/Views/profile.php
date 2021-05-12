<?= $this->extend('layouts/default'); ?>
<?= $this->section('content'); ?>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-6">
        <div class="card mt-2">
          <div class="card-header"><?= $user['firstname'].' '.$user['lastname'] ?>'s Profile</div>
          <div class="card-body">
            <?php if (session()->get('success')): ?>
              <div class="alert alert-success" role="alert">
                <?= session()->get('success') ?>
              </div>
            <?php endif; ?>
            <form class="" action="/profile" method="post">
              <div class="row">
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                   <label for="firstname">First Name</label>
                   <input type="text" class="form-control" name="firstname" id="firstname" value="<?= set_value('firstname', $user['firstname']) ?>">
                  </div>
                </div>
                <div class="col-12 col-sm-6">
                  <div class="form-group">
                   <label for="lastname">Last Name</label>
                   <input type="text" class="form-control" name="lastname" id="lastname" value="<?= set_value('lastname', $user['lastname']) ?>">
                  </div>
                </div>
                <div class="col-12">
                  <div class="form-group">
                   <label for="email">Email address</label>
                   <input type="text" class="form-control" readonly id="email" value="<?= $user['email'] ?>">
                  </div>
                </div>
              <?php if (isset($validation)): ?>
                <div class="col-12">
                  <div class="alert alert-danger" role="alert">
                    <?= $validation->listErrors() ?>
                  </div>
                </div>
              <?php endif; ?>
              </div>

              <div class="row">
                <div class="col-12 col-sm-4">
                  <button type="submit" class="btn btn-primary">Update</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
  </div>
</div>
<?= $this->endSection(); ?>