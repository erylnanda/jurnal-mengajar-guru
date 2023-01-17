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
                                <label for="nis" class="col-sm-3 col-form-label">NIS</label>
                                <div class="col-sm-9">
                                    <input type="hidden" name="dnis" id="dnis" value="<?= $dtsiswa['nis']; ?>">
                                    <input type="text" class="form-control" name="nis" id="nis" readonly value="<?= $dtsiswa['nis']; ?>">
                                    <?= form_error('nis', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="namasiswa" class="col-sm-3 col-form-label">Nama siswa</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="namasiswa" id="namasiswa" value="<?= $dtsiswa['namasiswa']; ?>">
                                    <?= form_error('namasiswa', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="jenkel" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                                <div class="col-sm-9">
                                    <select name="jenkel" id="jenkel" class="form-control">
                                        <option value="Laki-laki" <?= ($dtsiswa['jeniskelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                        <option value="Perempuan" <?= ($dtsiswa['jeniskelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <label for="kodekls" class="col-sm-3 col-form-label">Kelas</label>
                                <div class="col-sm-9">
                                    <select name="kodekls" id="kodekls" class="form-control">
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k['kodekelas']; ?>" <?= ($dtsiswa['kodekelas'] == $k['kodekelas']) ? 'selected' : ''; ?>><?= $k['kelas']; ?> <?= $k['namakelas']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="kodejur" class="col-sm-3 col-form-label">Jurusan</label>
                                <div class="col-sm-9">
                                    <select name="kodejur" id="kodejur" class="form-control">
                                        <?php foreach ($jurusan as $j) : ?>
                                            <option value="<?= $j['kodejurusan']; ?>" <?= ($dtsiswa['kodejurusan'] == $j['kodejurusan']) ? 'selected' : ''; ?>><?= $j['namajurusan']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="semester" class="col-sm-3 col-form-label">Semester</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="semester" id="semester" value="<?= $dtsiswa['semester_aktif']; ?>">
                                    <?= form_error('semester', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= base_url('master/siswa'.$dtkelas['kodekelas']); ?>" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary float-right">Ubah</button>
                    <?= form_close(); ?>
                </div>
            </div>

        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->