<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newMenuModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Add New Menu</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="" method="post">
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

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($menu)) : ?>
                            <tr>
                                <td colspan="7">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($menu as $m) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $m['menu']; ?></td>
                                <td>
                                    <a href="" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#ubahMenuModal<?= $m['id']; ?>">
                                        <span class="text">Ubah</span>
                                    </a>
                                    <a href="" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#hapusMenuModal<?= $m['id']; ?>">
                                        <span class="text">Hapus</span>
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
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newMenuModal" tabindex="-1" role="dialog" aria-labelledby="newMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newMenuModalLabel">Add New Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/tambahmenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Ubah Modal -->
<?php foreach ($menu as $m) : ?>
    <div class="modal fade" id="ubahMenuModal<?= $m['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ubahMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahMenuModalLabel">Ubah Menu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/ubahmenu'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="menu" name="menu" placeholder="Menu Name" value="<?= $m['menu']; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $m['id']; ?>">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-success" type="submit">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Hapus Modal-->
<?php foreach ($menu as $m) : ?>
    <div class="modal fade" id="hapusMenuModal<?= $m['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusMenuModalLabel">Yakin ingin dihapus?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/hapusmenu'); ?>" method="post">
                    <div class="modal-body">
                        <label>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi seperti semula.</label>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $m['id']; ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>