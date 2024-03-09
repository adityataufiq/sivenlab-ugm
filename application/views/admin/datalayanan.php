<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newLayModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('laboran/datalayanan'); ?>" method="post">
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
                            <th>Nama Layanan</th>
                            <th>Nama Laboratorium</th>
                            <th>Kepala Laboran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($lay)) : ?>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($lay as $l) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $l['kode']; ?></td>
                                <td><?= $l['layanan']; ?></td>
                                <td><?= $l['laboratorium']; ?></td>
                                <td><?= $l['kalaboran_name']; ?></td>
                                <td>
                                    <a href="<?= base_url('laboran/databarang/' . $l['id']); ?>" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="text">Lihat</span>
                                    </a>
                                    <a href="" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#ubahLayModal<?= $l['id']; ?>">
                                        <span class="text">Ubah</span>
                                    </a>
                                    <a href="" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#hapusLayModal<?= $l['id']; ?>">
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

    <!-- Hapus Lay Modal-->
    <?php foreach ($lay as $l) : ?>
        <div class="modal fade" id="hapusLayModal<?= $l['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusLayModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusLayModalLabel">Yakin ingin dihapus?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('laboran/hapuslayanan'); ?>" method="post">
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

    <!-- Ubah Lay Modal -->
    <?php foreach ($lay as $l) : ?>
        <div class="modal fade" id="ubahLayModal<?= $l['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ubahLayModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahLayModalLabel">Ubah Layanan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('laboran/ubahlayanan'); ?>" method="post">
                        <div class="modal-body">
                            <div class="form-group">
                                <select class="form-control" id="lab" name="lab">
                                    <option value="">Nama Laboratorium</option>
                                    <?php foreach ($labplease as $lab) : ?>
                                        <?php if ($lab['id'] == $l['laboratorium_id']) : ?>
                                            <option value="<?= $lab['id']; ?>" selected><?= $lab['laboratorium']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $lab['id']; ?>"><?= $lab['laboratorium']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Layanan" value="<?= $l['kode']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Nama Layanan" value="<?= $l['layanan']; ?>">
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

    <!-- Tambah Lay Modal -->
    <div class="modal fade" id="newLayModal" tabindex="-1" role="dialog" aria-labelledby="newLayModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newLayModalLabel">Tambah Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('laboran/tambahlayanan'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <select class="form-control" id="lab" name="lab">
                                <option value="">Nama Laboratorium</option>
                                <?php foreach ($labplease as $lab) : ?>
                                    <option value="<?= $lab['id']; ?>"><?= $lab['laboratorium']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Layanan">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Nama Layanan">
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