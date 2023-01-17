<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <span><a href="#"><?= $title; ?></a></span>
        <span> / <?= $subtitle; ?></span>
    </h1>

    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit </h6>
                </div>
                <div class="card-body">
                    <?= form_open('', ['class' => 'form-horizontal']); ?>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="nip" class="col-sm-3 col-form-label">Username</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="iduser" id="iduser" value="<?= $dtguru['iduser']; ?>">
                                    <input type="text" class="form-control" name="nip" id="nip" value="<?= $dtguru['namauser']; ?>" readonly>
                                    <?= form_error('namauser', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namalengkapuser" class="col-sm-3 col-form-label">Nama Guru</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="namalengkapuser" id="namalengkapuser" value="<?= $dtguru['namalengkapuser']; ?>">
                                    <?= form_error('namalengkapuser', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="passuser3" class="col-sm-12 col-form-label">Kosongkan Password bila tidak ingin diubah</label>
                            </div>
                            <div class="form-group row">
                                <label for="passuser" class="col-sm-3 col-form-label">Pass User</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="passuser2" id="passuser2" value="<?= $dtguru['passuser']; ?>">
                                    <input type="password" class="form-control" name="passuser" id="passuser" value="">
                                    <?= form_error('passuser', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="kodejurusan" class="col-sm-3 col-form-label">Jurusan</label>
                                <div class="col-sm-9">
                                    <select name="kodejurusan" id="kodejurusan" class="form-control">
                                        <?php foreach ($jurusan as $j) : ?>
                                            <option value="<?= $j['kodejurusan']; ?>" <?= ($dtguru['kodejurusan'] == $j['kodejurusan']) ? 'selected' : ''; ?>><?= $j['namajurusan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" value="<?= $dtguru['is_active']; ?>" name="is_active" id="is_active" <?= ($dtguru['is_active'] == '1') ? 'checked' : ''; ?>>
                                        <label for="is_active" class="form-check-label">
                                            Aktif?
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('master/userguru'); ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary float-right">Simpan</button>
                    <?= form_close(); ?>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->