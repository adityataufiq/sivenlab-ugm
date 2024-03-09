<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="row">
                <div class="col"></div>
                <div class="col-md-4">
                    <form action="<?= base_url('user/caribarang'); ?>" method="post">
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

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Barang</th>
                            <th>Merk / Seri</th>
                            <th>Nama Layanan</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($search)) : ?>
                            <tr>
                                <td colspan="5">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($search as $srch) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $srch['barang']; ?></td>
                                <td><?= $srch['spesifikasi']; ?></td>
                                <td><?= $srch['layanan']; ?></td>
                                <td><?= $srch['jumlah_baik']; ?></td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailBarangModal<?= $srch['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-globe"></i>
                                        </span>
                                    </a>
                                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#pinjamBarangModal<?= $srch['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-arrow-right"></i>
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
</div>
<!-- End of Main Content -->

<!-- Detail Modal -->
<?php foreach ($search as $srch) : ?>
    <div class="modal fade" id="detailBarangModal<?= $srch['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailBarangModalLabel">Detail Barang</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive"></div>
                    <table class="table-borderless">
                        <tbody class="table">
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Nama Barang</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $srch['barang']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Merk / Seri</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $srch['spesifikasi']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Jumlah</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $srch['jumlah_baik']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Layanan</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $srch['layanan']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Laboratorium</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $srch['laboratorium']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Departemen / Program Studi</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $srch['departemen']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Keterangan</label>
                                </td>
                                <td>
                                    <?php if ($srch['keterangan'] == null) { ?>
                                        <label class="font-weight-light">: -</label>
                                    <?php } else { ?>
                                        <label class="font-weight-light">: <?= $srch['keterangan']; ?></label>
                                    <?php } ?>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Pinjam Modal -->
<?php foreach ($search as $srch) : ?>
    <div class="modal fade" id="pinjamBarangModal<?= $srch['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="pinjamBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pinjamBarangModalLabel">Pinjam Barang</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('user/pinjambarang/'); ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="laboratorium_id" name="laboratorium_id" value="<?= $srch['laboratorium_id'] ?>">
                        <input type="hidden" class="form-control" id="layanan_id" name="layanan_id" value="<?= $srch['layanan_id'] ?>">
                        <input type="hidden" class="form-control" id="barang_id" name="barang_id" value="<?= $srch['id'] ?>">
                        <input type="hidden" class="form-control" id="kode" name="kode" value="<?= rand() ?>">
                        <input type="hidden" class="form-control" id="barang_barang" name="barang_barang" value="<?= $srch['barang'] ?>">
                        <input type="hidden" class="form-control" id="barang_spesifikasi" name="barang_spesifikasi" value="<?= $srch['spesifikasi'] ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_kembali" class="font-weight-light">Tanggal Kembali :</label>
                            <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control">
                        </div>
                        <input type="hidden" class="form-control" id="to_laboran" name="to_laboran" value="<?= $srch['laboran_id'] ?>">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Pinjam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>
</div>