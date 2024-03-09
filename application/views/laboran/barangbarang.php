<!-- /.container-fluid -->
<div class="container-fluid">

    <!-- Page Heading -->
    <!-- <h1 class="h3 mb-4 text-gray-800"></h1> -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col-lg-0 ml-3">
                    <a href="<?= base_url('laboran/datalayanan/'); ?>">
                        <i class="fas fa-chevron-circle-left"></i>
                    </a>
                </div>
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Barang : <?= $layanan['layanan']; ?></h6>
                </div>
            </div>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col">
                    <a href="<?= base_url('laboran/datalayanan/'); ?>" class="btn btn-warning btn-icon-split mb-3">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-arrow-left"></i>
                        </span>
                        <span class="text">Kembali</span>
                    </a>
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newBarangModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Tambah</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('laboran/databarang/' . $layanan['id']); ?>" method="post">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search for..." name="keyword">
                            <div class="input-group-append">
                                <input class="btn btn-light border" type="submit" name="submit" value="Cari"></input>
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
                            <th>Tanggal</th>
                            <th>Nama Barang</th>
                            <th>Merk / Seri</th>
                            <th>Kondisi Baik</th>
                            <th>Kondisi Rusak</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($barang)) : ?>
                            <tr>
                                <td colspan="7">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($barang as $brg) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= date('d F Y', $brg['tanggal']); ?></td>
                                <td><?= $brg['barang']; ?></td>
                                <td><?= $brg['spesifikasi']; ?></td>
                                <td><?= $brg['jumlah_baik']; ?></td>
                                <td><?= $brg['jumlah_rusak']; ?></td>
                                <td>
                                    <a href="" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#detailBarangModal<?= $brg['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-globe"></i>
                                        </span>
                                    </a>
                                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubahBarangModal<?= $brg['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </span>
                                    </a>

                                    <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusBarangModal<?= $brg['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-trash"></i>
                                        </span>
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

    <!-- Tambah Modal -->
    <div class="modal fade" id="newBarangModal" tabindex="-1" role="dialog" aria-labelledby="newBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('laboran/tambahbarang/') . $layanan['id']; ?>" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="laboratorium_id" name="laboratorium_id" value="<?= $layanan['laboratorium_id']; ?>">
                        <input type="hidden" class="form-control" id="layanan_id" name="layanan_id" value="<?= $layanan['id']; ?>">
                        <div class="form-group">
                            <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Barang">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="barang" name="barang" placeholder="Nama Barang">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" placeholder="Merk / Seri Barang">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="jumlah_baik" name="jumlah_baik" placeholder="Jumlah Barang Kondisi Baik">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="jumlah_rusak" name="jumlah_rusak" placeholder="Jumlah Barang Kondisi Rusak">
                        </div>
                        <div class="form-group form-group-inline">
                            <label>Bisa dipinjam?</label>
                            <div class="form-check form-check-inline">
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="bisa_dipinjam" name="bisa_dipinjam" value="1" checked>
                                <label class="form-check-label" for="bisa_dipinjam">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="bisa_dipinjam" name="bisa_dipinjam" value="0">
                                <label class="form-check-label" for="bisa_dipinjam">Tidak</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Keterangan : </label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="*tidak wajib diisi">
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

    <!-- Detail Modal -->
    <?php foreach ($barang as $brg) : ?>
        <div class="modal fade" id="detailBarangModal<?= $brg['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="detailBarangModalLabel" aria-hidden="true">
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
                                        <label class="font-weight-bold">Kode</label>
                                    </td>
                                    <td>
                                        <label class="font-weight-light">: <?= $brg['kode']; ?></label>
                                    </td>
                                <tr>
                                    <td>
                                        <label class="font-weight-bold">Nama Barang</label>
                                    </td>
                                    <td>
                                        <label class="font-weight-light">: <?= $brg['barang']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="font-weight-bold">Merk / Seri</label>
                                    </td>
                                    <td>
                                        <label class="font-weight-light">: <?= $brg['spesifikasi']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="font-weight-bold">Kondisi Baik</label>
                                    </td>
                                    <td>
                                        <label class="font-weight-light">: <?= $brg['jumlah_baik']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="font-weight-bold">Kondisi Rusak</label>
                                    </td>
                                    <td>
                                        <label class="font-weight-light">: <?= $brg['jumlah_rusak']; ?></label>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="font-weight-bold">Bisa Dipinjam</label>
                                    </td>
                                    <?php if ($brg['bisa_dipinjam'] == 1) { ?>
                                        <td>
                                            <label class="font-weight-light">: Ya</label>
                                        </td>
                                    <?php } else { ?>
                                        <td>
                                            <label class="font-weight-light">: Tidak</label>
                                        </td>
                                    <?php } ?>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="font-weight-bold">Keterangan</label>
                                    </td>
                                    <td>
                                        <?php if ($brg['keterangan'] == null) { ?>
                                            <label class="font-weight-light">: -</label>
                                        <?php } else { ?>
                                            <label class="font-weight-light">: <?= $brg['keterangan']; ?></label>
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

    <!-- Hapus Modal-->
    <?php foreach ($barang as $brg) : ?>
        <div class="modal fade" id="hapusBarangModal<?= $brg['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusBarangModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="hapusBarangModalLabel">Yakin ingin dihapus?</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('laboran/hapusbarang'); ?>" method="post">
                        <div class="modal-body">
                            <label>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi seperti semula.</label>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $brg['id']; ?>">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <!-- Ubah Modal -->
    <?php foreach ($barang as $brg) : ?>
        <div class="modal fade" id="ubahBarangModal<?= $brg['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ubahBarangModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ubahBarangModalLabel">Ubah Barang</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="<?= base_url('laboran/ubahbarang'); ?>" method="post">
                        <div class="modal-body">
                            <input type="hidden" class="form-control" id="layanan_id" name="layanan_id" value="<?= $layanan['id']; ?>">
                            <div class="form-group">
                                <input type="text" class="form-control" id="kode" name="kode" placeholder="Kode Barang" value="<?= $brg['kode']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="barang" name="barang" placeholder="Nama Barang" value="<?= $brg['barang']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="spesifikasi" name="spesifikasi" placeholder="Merk / Seri Barang" value="<?= $brg['spesifikasi']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="jumlah_baik" name="jumlah_baik" placeholder="Jumlah Barang Kondisi Baik" value="<?= $brg['jumlah_baik']; ?>">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="jumlah_rusak" name="jumlah_rusak" placeholder="Jumlah Barang Kondisi Rusak" value="<?= $brg['jumlah_rusak']; ?>">
                            </div>
                            <div class="form-group form-group-inline">
                                <label>Bisa dipinjam?</label>
                                <div class="form-check form-check-inline">
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="bisa_dipinjam" name="bisa_dipinjam" value="1" <?php if ($brg['bisa_dipinjam'] == 1) { ?> checked <?php } else { ?> unchecked <?php } ?>>
                                    <label class="form-check-label" for="bisa_dipinjam">Ya</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" id="bisa_dipinjam" name="bisa_dipinjam" value="0" <?php if ($brg['bisa_dipinjam'] == 0) { ?> checked <?php } else { ?> unchecked <?php } ?>>
                                    <label class="form-check-label" for="bisa_dipinjam">Tidak</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Keterangan : </label>
                                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= $brg['keterangan']; ?>" placeholder="*tidak wajib diisi">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="id" value="<?= $brg['id']; ?>">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                            <button class="btn btn-success" type="submit">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

</div>
</div>