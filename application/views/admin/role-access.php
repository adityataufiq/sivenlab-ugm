<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"></h1> -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-0 ml-3">
                    <a href="<?= base_url('admin/role'); ?>">
                        <i class="fas fa-chevron-circle-left"></i>
                    </a>
                </div>
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Role Access : <?= $role['role']; ?></h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <?= $this->session->flashdata('message'); ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Access</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        <?php foreach ($menu as $m) : ?>
                            <tr>
                                <th scope="row"><?= ++$i; ?></th>
                                <td><?= $m['menu']; ?></td>
                                <td>
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" name="check1" <?= check_access($role['id'], $m['id']); ?> data-role="<?= $role['id']; ?>" data-menu="<?= $m['id']; ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
</div>
<!-- End of Main Content -->