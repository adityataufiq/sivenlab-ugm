<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="card shadow mb-4">

        <div class="card-body">

            <div class="row">
                <div class="col">
                    <a href="" class="btn btn-primary btn-icon-split mb-3" data-toggle="modal" data-target="#newSubMenuModal">
                        <span class="icon text-white-50">
                            <i class="fas fa-fw fa-plus"></i>
                        </span>
                        <span class="text">Add New Sub Menu</span>
                    </a>
                </div>
                <div class="col-md-4">
                    <form action="<?= base_url('menu/submenu'); ?>" method="post">
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

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Menu</th>
                            <th scope="col">Url</th>
                            <th scope="col">Icon</th>
                            <th scope="col">Active</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($subMenu)) : ?>
                            <tr>
                                <td colspan="7">
                                    <div class="alert alert-danger" role="alert">
                                        <label style="display:block; text-align:center">Data tidak ditemukan.</label>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                        <?php foreach ($subMenu as $sm) : ?>
                            <tr>
                                <th scope="row"><?= ++$start; ?></th>
                                <td><?= $sm['title']; ?></td>
                                <td><?= $sm['menu']; ?></td>
                                <td><?= $sm['url']; ?></td>
                                <td><?= $sm['icon']; ?></td>
                                <td><?= $sm['is_active']; ?></td>
                                <td>
                                    <a href="" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ubahSubMenuModal<?= $sm['id']; ?>">
                                        <span class="icon">
                                            <i class="fas fa-fw fa-edit"></i>
                                        </span>
                                    </a>

                                    <a href="" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapusSubMenuModal<?= $sm['id']; ?>">
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
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/tambahSubMenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Sub Menu Title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class=form-control>
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Sub Menu Url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub Menu Icon">
                    </div>
                    <div class="form-group form-group-inline">
                        <label>Active?</label>
                        <div class="form-check form-check-inline">
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                            <label class="form-check-label" for="is_active">Ya</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="0">
                            <label class="form-check-label" for="is_active">Tidak</label>
                        </div>
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
<?php foreach ($subMenu as $sm) : ?>
    <div class="modal fade" id="ubahSubMenuModal<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="ubahSubMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ubahSubMenuModalLabel">Ubah Sub Menu</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/ubahsubmenu'); ?>" method="post">
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" id="title" name="title" value="<?= $sm['title']; ?>" placeholder="Sub Menu Title">
                        </div>
                        <div class="form-group">
                            <select name="menu_id" id="menu_id" class=form-control>
                                <option value="">Select Menu</option>
                                <?php foreach ($menu as $m) : ?>
                                    <?php if ($m['id'] == $sm['menu_id']) : ?>
                                        <option value="<?= $m['id']; ?>" selected><?= $m['menu']; ?></option>
                                    <?php else : ?>
                                        <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="url" name="url" value="<?= $sm['url']; ?>" placeholder="Sub Menu Url">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" id="icon" name="icon" value="<?= $sm['icon']; ?>" placeholder="Sub Menu Icon">
                        </div>
                        <div class="form-group form-group-inline">
                            <label>Active?</label>
                            <div class="form-check form-check-inline">
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" <?php if ($sm['is_active'] == 1) { ?> checked <?php } else { ?> unchecked <?php } ?>>
                                <label class="form-check-label" for="is_active">Ya</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="0" <?php if ($sm['is_active'] == 0) { ?> checked <?php } else { ?> unchecked <?php } ?>>
                                <label class="form-check-label" for="is_active">Tidak</label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $sm['id']; ?>">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <button class="btn btn-success" type="submit">Ubah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<!-- Hapus Modal-->
<?php foreach ($subMenu as $sm) : ?>
    <div class="modal fade" id="hapusSubMenuModal<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="hapusSubMenuModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="hapusSubMenuModalLabel">Yakin ingin dihapus?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="<?= base_url('menu/hapussubmenu'); ?>" method="post">
                    <div class="modal-body">
                        <label>Data akan dihapus secara permanen dan tidak dapat dikembalikan lagi seperti semula.</label>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="id" value="<?= $sm['id']; ?>">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endforeach; ?>