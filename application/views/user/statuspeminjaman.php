<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">

        <div class="card-body">
            <div class="row">
                <div class="col"></div>
                <div class="col-md-4">
                    <form action="<?= base_url('user/statuspeminjaman'); ?>" method="post">
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

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Kode</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Nama Layanan</th>
                            <th>Tanggal Diajukan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($pinjamdong)) : ?>
                            <tr>
                                <td colspan="8">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($pinjamdong as $pnjmdng) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $pnjmdng['kode']; ?></td>
                                <td><?= $pnjmdng['barang_barang']; ?></td>
                                <td><?= $pnjmdng['jumlah']; ?></td>
                                <td><?= $pnjmdng['layanan']; ?></td>
                                <td><?= date('d F Y', $pnjmdng['tanggal_pinjam']); ?></td>
                                <td><?php if ($pnjmdng['status'] == null) { ?>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Menunggu</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 3) { ?>
                                        <a class="btn btn-success btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Selesai</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 2) { ?>
                                        <a class="btn btn-info btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Sedang dipinjam</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 1) { ?>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Diteruskan</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 0) { ?>
                                        <a class="btn btn-danger btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Ditolak</span>
                                        </a>
                                    <?php } ?>
                                </td>

                                <td>
                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailPinjamModal<?= $pnjmdng['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-globe"></i>
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
</div>

<!-- End of Main Content -->

<!-- Detail Modal -->
<?php foreach ($pinjamdong as $pnjmdng) : ?>
    <div class="modal fade" id="detailPinjamModal<?= $pnjmdng['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailPinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailPinjamModalLabel">Detail Peminjaman</h5>
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
                                    <label class="font-weight-light">: <?= $pnjmdng['barang_barang']; ?></label>
                                </td>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Merk / Seri</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $pnjmdng['barang_spesifikasi']; ?></label>
                                </td>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Jumlah</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $pnjmdng['jumlah']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Layanan</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $pnjmdng['layanan']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Laboratorium</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $pnjmdng['laboratorium']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Departemen / Program Studi</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $pnjmdng['departemen']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Tanggal Kembali</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $pnjmdng['tanggal_kembali']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Status</label>
                                </td>
                                <td>
                                    <?php if ($pnjmdng['status'] == null) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Menunggu</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 3) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-success btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Selesai</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 2) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-info btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Sedang Dipinjam</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 1) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Diteruskan</span>
                                        </a>
                                    <?php } elseif ($pnjmdng['status'] == 0) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-danger btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Ditolak</span>
                                        </a>
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