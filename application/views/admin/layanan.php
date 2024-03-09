<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"></h1> -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-0 ml-3">
                    <a href="<?= base_url('kalaboran/lab'); ?>">
                        <i class="fas fa-chevron-circle-left"></i>
                    </a>
                </div>
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Layanan : <?= $lab['laboratorium']; ?></h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <a href="<?= base_url('kalaboran/lab'); ?>" class="btn btn-warning btn-icon-split mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-arrow-left"></i>
                        </span>
                        <span class="text">Kembali</span>
                    </a>

                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newLayananModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('kalaboran/layanan/' . $lab['id']); ?>" method="post">
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
                            <th>Laboran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($layanan)) : ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($layanan as $lyn) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $lyn['kode']; ?></td>
                                <td><?= $lyn['layanan']; ?></td>
                                <td><?= $lyn['laboran_name']; ?></td>

                                <td>
                                    <a href="<?= base_url('kalaboran/databarang/' . $lyn['id']); ?>" class="btn btn-primary btn-icon-split btn-sm">
                                        <span class="text">Lihat</span>
                                    </a>
                                    <a href="" class="btn btn-success btn-icon-split btn-sm" data-toggle="modal" data-target="#ubahLayananModal<?= $lyn['id']; ?>">
                                        <span class="text">Ubah</span>
                                    </a>
                                    <a href="" class="btn btn-danger btn-icon-split btn-sm" data-toggle="modal" data-target="#hapusLayananModal<?= $lyn['id']; ?>">
                                        <span class="text">Hapus</span>
                                    </a>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?= $this->pagination->create_links(); ?>
            </div>
        </div>
    </div>

    <!-- End of Main Content -->

    <!-- Hapus Layanan Modal-->
    <?php foreach ($layanan as $lyn) : ?>
        <div class="modal fade" id="hapusLayananModal<?= $lyn['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusLayananModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusLayananModalLabel">Yakin ingin dihapus?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('kalaboran/hapuslayanan'); ?>" method="post">
                        <div class="modal-body">
                            <label>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi seperti semula.</label>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $lyn['id']; ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Ubah Layanan Modal -->
    <?php foreach ($layanan as $lyn) : ?>
        <div class="modal fade" id="ubahLayananModal<?= $lyn['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ubahLayananModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahLayananModalLabel">Ubah Layanan</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('kalaboran/ubahlayanan'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="laboratorium_id" name="laboratorium_id" value="<?= $lyn['laboratorium_id']; ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Layanan" value="<?= $lyn['kode']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Nama Layanan" value="<?= $lyn['layanan']; ?>">
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="laboran_id" name="laboran_id">
                                    <option value="">Nama Laboran</option>
                                    <?php foreach ($laboran as $lbrn) : ?>
                                        <?php if ($lbrn['id'] == $lyn['laboran_id']) : ?>
                                            <option value="<?= $lbrn['id']; ?>" selected><?= $lbrn['name']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $lbrn['id']; ?>"><?= $lbrn['name']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control" id="laboran_name" name="laboran_name">
                                    <option value="">Konfirmasi Nama Laboran</option>
                                    <?php foreach ($laboran as $lbrn) : ?>
                                        <?php if ($lbrn['name'] == $lyn['laboran_name']) : ?>
                                            <option value="<?= $lbrn['name']; ?>" selected><?= $lbrn['name']; ?></option>
                                        <?php else : ?>
                                            <option value="<?= $lbrn['name']; ?>"><?= $lbrn['name']; ?></option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $lyn['id']; ?>">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-success" type="submit">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Tambah Modal -->
    <div class="modal fade" id="newLayananModal" tabindex="-1" role="dialog" aria-labelledby="newLayananModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newLayananModalLabel">Tambah Layanan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('kalaboran/tambahlayanan/') . $lab['id']; ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="laboratorium_id" name="laboratorium_id" value="<?= $lab['id']; ?>">
                        <input type="hidden" class="form-control" id="kalaboran_id" name="kalaboran_id" value="<?= $lab['kalaboran_id']; ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Layanan">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="layanan" name="layanan" placeholder="Nama Layanan">
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="laboran_id" name="laboran_id">
                                <option value="">Nama Laboran</option>
                                <?php foreach ($laboran as $lbrn) : ?>
                                    <option value="<?= $lbrn['id']; ?>"><?= $lbrn['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select class="form-control" id="laboran_name" name="laboran_name">
                                <option value="">Konfirmasi Nama Laboran</option>
                                <?php foreach ($laboran as $lbrn) : ?>
                                    <option value="<?= $lbrn['name']; ?>"><?= $lbrn['name']; ?></option>
                                <?php endforeach; ?>
                            </select>
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