<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <!-- <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Laboratorium</h6>
        </div> -->
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newLabModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('kalaboran/lab'); ?>" method="post">
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

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Laboratorium</th>
                            <th>Departemen / Program Studi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lab)) : ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($lab as $l) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $l['kode']; ?></td>
                                <td><?= $l['laboratorium']; ?></td>
                                <td><?= $l['departemen']; ?></td>
                                <td>
                                    <a href="<?= base_url('kalaboran/layanan/' . $l['id']); ?>" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="text">Lihat</span>
                                    </a>
                                    <a href="" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#ubahLabModal<?= $l['id']; ?>">
                                        <span class="text">Ubah</span>
                                    </a>
                                    <a href="" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#hapusLabModal<?= $l['id']; ?>">
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

    <!-- End of Main Content -->

    <!-- Hapus Lab Modal-->
    <?php foreach ($lab as $l) : ?>
        <div class="modal fade" id="hapusLabModal<?= $l['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusLabModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusLabModalLabel">Yakin ingin dihapus?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('kalaboran/hapuslab'); ?>" method="post">
                        <div class="modal-body">
                            <label>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi seperti semula.</label>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $l['id']; ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Ubah Lab Modal -->
    <?php foreach ($lab as $l) : ?>
        <div class="modal fade" id="ubahLabModal<?= $l['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ubahLabModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahLabModalLabel">Ubah Laboratorium</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('kalaboran/ubahlab'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Laboratorium" value="<?= $l['kode']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="laboratorium" name="laboratorium" placeholder="Nama Laboratorium" value="<?= $l['laboratorium']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="departemen" name="departemen" placeholder="Departemen / Program Studi" value="<?= $l['departemen']; ?>">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $l['id']; ?>">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-success" type="submit">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Tambah Lab Modal -->
    <div class="modal fade" id="newLabModal" tabindex="-1" role="dialog" aria-labelledby="newLabModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newLabModalLabel">Tambah Laboratorium</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('kalaboran/tambahlab'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Laboratorium">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="laboratorium" name="laboratorium" placeholder="Nama Laboratorium">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="departemen" name="departemen" placeholder="Departemen / Program Studi">
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