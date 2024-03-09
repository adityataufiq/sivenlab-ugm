<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newUserModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('admin/datapengguna'); ?>" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search for..." name="keyword" autocomplete="off">
                            <div class="input-group-append">
                                <input class="btn btn-light border" type="submit" name="submit" value="Cari">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <?= $this->session->flashdata('message'); ?>
            <?= $this->session->flashdata('error1'); ?>
            <?= $this->session->flashdata('error2'); ?>
            <?= $this->session->flashdata('error3'); ?>
            <?= $this->session->flashdata('error4'); ?>
            <?= $this->session->flashdata('error5'); ?>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php foreach ($role as $r) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $r['name']; ?></td>
                                <td><?= $r['email']; ?></td>
                                <td><?= $r['role']; ?></td>
                                <td>
                                    <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusPenggunaModal<?= $r['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $this->pagination->create_links(); ?>

            </div>
        </div>
    </div>

    <!-- End of Main Content -->

    <!-- Hapus Modal-->
    <?php foreach ($role as $r) : ?>
        <div class="modal fade" id="hapusPenggunaModal<?= $r['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusPenggunaModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusPenggunaModalLabel">Yakin ingin dihapus?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('admin/hapuspengguna'); ?>" method="post">
                        <div class="modal-body">
                            <label>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi seperti semula.</label>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $r['id']; ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Modal -->
    <div class="modal fade" id="newUserModal" tabindex="-1" role="dialog" aria-labelledby="newUserModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newUserModalLabel">Tambah User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('admin/tambahpengguna'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="email" name="email" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="role_id" name="role_id" placeholder="Role">
                                <option value="">Select Role</option>
                                <?php foreach ($role_id as $rid) : ?>
                                    <option value="<?= $rid['id']; ?>"><?= $rid['role']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>