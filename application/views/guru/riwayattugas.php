<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">
        <span><a href="#"><?= $title; ?></a></span>
        <span> / <?= $subtitle; ?></span>
    </h1>

    <div class="flash-data" data-flashdata="<?= $this->session->flashdata('message'); ?>"></div>

    <div class="row">

        <div class="col-lg-12">
            <div class="alert alert-warning bg-warning" style="color: #000; font-size: small;">
                <b>Petunjuk : </b><br>
                <ul>
                    <li>
                        Menu ini digunakan untuk mengedit nilai tugas siswa pada setiap masing-masing kopentesi dasar. Silakan klik tombol " <i class="fas fa-fw fa-edit"></i> " , dan akan muncul modal daftar siswa serta isian nalainya. Jangan lupa klik tombol <b><i>Simpan</i></b> di bagian bawah.</li>
                    </li>
                    <li>Apabila data pada tabel kosong, artinya data nilai tugas belum ditambahkan. Silahkan kembali ke halaman mapel diampu klik menu <b><i>" Input Nilai Tugas Baru "</i></b></li>
                </ul>
            </div>
        </div>

        <div class="col-lg-10">

            <div class="card shadow md-4">
                <div class="card-header py-3">
                    <dl class="row mb-0">
                        <dt class="col-sm-4">Mata Pelajaran</dt>
                        <dd class="col-sm-8"><?= $mapel['namamapel']; ?></dd>
                        <dt class="col-sm-4">Kelas</dt>
                        <dd class="col-sm-8"><?= $kelas['kelas']; ?> <?= $kelas['namakelas']; ?></dd>
                    </dl>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Mata Pelajaran</th>
                                    <th scope="col">Kopentesi Dasar</th>
                                    <th scope="col">Tugas Ke</th>
                                    <th scope="col">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; 
                                $b = "a";?>
                                <?php foreach ($tugas as $a) :
                                    if (($a['namakd']!=$b)&&($a["tugas"]<=$i)) {?>
                                    <?php for ($x=0; $x<$a["tugas"]; $x++) {
                                        $v = $x+1 ?>
                                        <tr>
                                            <th scope="row"><?= $i; ?></th>
                                            <td><?= $a['namamapel']; ?></td>
                                            <td><?= $a['namakd']; ?></td>
                                            <td><?= $v ?></td>
                                            <td>
                                                <a href="<?= base_url('guru/edittugas/' . $a['idkd'] . '/' . $v . '/' . $idajar . '/' . $kelas['kodekelas']); ?>" class="btn btn-sm btn-outline-primary" title="Edit Nilai"><i class="fas fa-fw fa-pencil-alt"></i> Edit Nilai</a>
                                            </td>
                                        </tr>
                                        <?php $i++; ?>
                                    <?php }
                                        } $b = $a['namakd'];?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->