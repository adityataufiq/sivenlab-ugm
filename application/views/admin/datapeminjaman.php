<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col"></div>
                <div class="col-md-4">
                    <form action="<?= base_url('kalaboran/datapeminjaman'); ?>" method="post">
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
                            <th>Pemohon</th>
                            <th>Tanggal Diajukan</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($maupinjam)) : ?>
                            <tr>
                                <td colspan="9">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <?php foreach ($maupinjam as $mpnjm) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $mpnjm['kode']; ?></td>
                                <td><?= $mpnjm['barang_barang']; ?></td>
                                <td><?= $mpnjm['jumlah']; ?></td>
                                <td><?= $mpnjm['user_name']; ?></td>
                                <td><?= date('d F Y', $mpnjm['tanggal_pinjam']); ?></td>
                                <td><?= $mpnjm['tanggal_kembali']; ?></td>
                                <td><?php if ($mpnjm['status'] == null) { ?>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Menunggu</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 3) { ?>
                                        <a class="btn btn-success btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Selesai</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 2) { ?>
                                        <a class="btn btn-info btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Sedang Dipinjam</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 1) { ?>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Diteruskan</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 0) { ?>
                                        <a class="btn btn-danger btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Ditolak</span>
                                        </a>
                                    <?php } ?>
                                </td>

                                <td><?php if ($mpnjm['status'] == null) { ?>
                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-globe"></i>
                                            </span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 3) { ?>
                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-globe"></i>
                                            </span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 2) { ?>
                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-globe"></i>
                                            </span>
                                        </a>
                                        <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#selesaiPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-flag-checkered"></i>
                                            </span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 1) { ?>
                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-globe"></i>
                                            </span>
                                        </a>
                                        <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#terimaPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-check"></i>
                                            </span>
                                        </a>
                                        <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#tolakPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-times"></i>
                                            </span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 0) { ?>
                                        <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailPinjamModal<?= $mpnjm['id']; ?>">
                                            <span class="icon">
                                                <i class="fas fa-fw fa-globe"></i>
                                            </span>
                                        </a>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

<!-- End of Main Content -->

<!-- Detail Modal -->
<?php foreach ($maupinjam as $mpnjm) : ?>
    <div class="modal fade" id="detailPinjamModal<?= $mpnjm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailPinjamModalLabel" aria-hidden="true">
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
                                    <label class="font-weight-light">: <?= $mpnjm['barang_barang']; ?></label>
                                </td>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Merk / Seri</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $mpnjm['barang_spesifikasi']; ?></label>
                                </td>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Jumlah</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $mpnjm['jumlah']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Layanan</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $mpnjm['layanan']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Laboratorium</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $mpnjm['laboratorium']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Departemen / Program Studi</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $mpnjm['departemen']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Tanggal Kembali</label>
                                </td>
                                <td>
                                    <label class="font-weight-light">: <?= $mpnjm['tanggal_kembali']; ?></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label class="font-weight-bold">Status</label>
                                </td>
                                <td>
                                    <?php if ($mpnjm['status'] == null) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Menunggu</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 3) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-success btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Selesai</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 2) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-info btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Sedang Dipinjam</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 1) { ?>
                                        <label class="font-weight-light">: </label>
                                        <a class="btn btn-warning btn-icon-split btn-sm">
                                            <span class="text" style="color:white">Diteruskan</span>
                                        </a>
                                    <?php } elseif ($mpnjm['status'] == 0) { ?>
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

<!-- Tolak Pinjam Modal-->
<?php foreach ($maupinjam as $mpnjm) : ?>
    <div class="modal fade" id="tolakPinjamModal<?= $mpnjm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="tolakPinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tolakPinjamModalLabel">Yakin ingin ditolak?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('kalaboran/tolakpinjam'); ?>" method="post">
                    <div class="modal-body">
                        <label>Permintaan peminjaman barang oleh pemohon akan dibatalkan.</label>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $mpnjm['id']; ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Terima Pinjam Modal-->
<?php foreach ($maupinjam as $mpnjm) : ?>
    <div class="modal fade" id="terimaPinjamModal<?= $mpnjm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="terimaPinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="terimaPinjamModalLabel">Terima Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('kalaboran/terimapinjam'); ?>" method="post">
                    <div class="modal-body">
                        <label>Permintaan peminjaman barang oleh pemohon akan diterima.</label>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $mpnjm['id']; ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Terima</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Selesai Pinjam Modal-->
<?php foreach ($maupinjam as $mpnjm) : ?>
    <div class="modal fade" id="selesaiPinjamModal<?= $mpnjm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="selesaiPinjamModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selesaiPinjamModalLabel">Selesai Peminjaman</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('kalaboran/selesaipinjam'); ?>" method="post">
                    <div class="modal-body">
                        <label>Peminjaman barang telah selesai.</label>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $mpnjm['id']; ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Selesai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>