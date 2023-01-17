<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <?= $title; ?> <?= $kelas['kelas']; ?> <?= $kelas['namakelas']; ?>
    </h1>

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <div class="row">

        <div class="col-lg-9">

            <div class="card shadow md-4">
                <div class="card-header py-3">
                </div>
                <div class="card-body">
                        <div class="table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">NIS</th>
                                        <th scope="col">Nama</th>
                                        <th scope="col">Hadir</th>
                                        <th scope="col">Sakit</th>
                                        <th scope="col">Izin</th>
                                        <th scope="col">Alfa</th>
                                        <th scope="col">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $i = 1; ?>
                                    <?php foreach ($ambil as $a) : ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $a->nis; ?></td>
                                            <td><?= $a->namasiswa; ?></td>
                                            <td><?= $a->hadir; ?></td>
                                            <td><?= $a->sakit; ?></td>
                                            <td><?= $a->izin; ?></td>
                                            <td><?= $a->alfa; ?></td>
                                            <td><?= $a->hadir+$a->sakit+$a->izin+$a->alfa; ?></td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <p>
                            <a href="<?= base_url('guru/riwayat'); ?>" class="btn btn-sm btn-outline-danger" title="Kembali"><i class="fas fa-fw fa-arrow-left"></i> Kembali</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->