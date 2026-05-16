<?php
/**
 * Created by IntelliJ IDEA.
 * User: multazam
 * Date: 23/08/20
 * Time: 23:18
 */
?>
<div class="content-wrapper">
    <div class="sticky">
    </div>
    <section class="content overlap p-4">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php $this->load->view('members/siswa/templates/top'); ?>
                </div>
            </div>

            <div class="container-fluid h-100">
                <div class="row h-100 justify-content-center">
                    <div class="col-md-8 col-lg-6">
                        <div class="card my-shadow">
                            <div class="card-body p-0">
                                <?php
                                //var_dump($pengawas);
                                if ($support && $valid) :
                                    $jk = json_decode(json_encode($bank->bank_kelas));
                                    $jumlahKelas = json_decode(json_encode(unserialize($jk ?? '')));
                                    $kelasbank = '';
                                    $no = 1;
                                    foreach ($jumlahKelas as $j) {
                                        foreach ($kelas as $k) {
                                            if ($j->kelas_id === $k->id_kelas) {
                                                if ($no > 1) $kelasbank .= ', ';
                                                $kelasbank .= $k->nama_kelas;
                                                $no++;
                                            }
                                        }
                                    }
                                    $jml_soal = $bank->tampil_pg + $bank->tampil_kompleks + $bank->tampil_jodohkan + $bank->tampil_isian + $bank->tampil_esai;
                                ?>
                                    <!-- Header -->
                                    <div class="konfirmasi-header">
                                        <div class="konfirmasi-badge">
                                            <i class="fas fa-clipboard-check"></i>
                                            Konfirmasi Ujian
                                        </div>
                                        <h3><?= $bank->nama_mapel ?></h3>
                                        <p class="konfirmasi-sub"><?= $bank->kode_jenis . ' &bull; ' . $bank->tahun . ' &bull; Semester ' . $bank->smt ?></p>
                                    </div>

                                    <?= form_open('', array('id' => 'konfir')) ?>
                                    <input type="hidden" name="siswa" value="<?= $siswa->id_siswa ?>">
                                    <input type="hidden" name="jadwal" value="<?= $bank->id_jadwal ?>">
                                    <input type="hidden" name="bank" value="<?= $bank->id_bank ?>">

                                    <!-- Info list -->
                                    <ul class="list-group list-group-unbordered konfirmasi-info px-3">
                                        <li class="list-group-item">
                                            <span class="item-label"><i class="fas fa-users mr-1"></i> Kelas</span>
                                            <span class="item-value"><?= $kelasbank ?></span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="item-label"><i class="fas fa-clock mr-1"></i> Durasi</span>
                                            <span class="item-value"><?= $bank->durasi_ujian ?> Menit</span>
                                        </li>
                                        <li class="list-group-item">
                                            <span class="item-label"><i class="fas fa-list-ol mr-1"></i> Jumlah Soal</span>
                                            <span class="item-value"><?= $jml_soal ?> Soal</span>
                                        </li>
                                        <?php if ($bank->token === '1') : ?>
                                        <li class="list-group-item">
                                            <span class="item-label"><i class="fas fa-key mr-1 text-danger"></i> <span class="text-danger">Token</span></span>
                                            <span class="item-value">
                                                <input type="text" id="input-token"
                                                       class="form-control form-control-sm token-input"
                                                       name="token" placeholder="• • • • • •" autocomplete="off"/>
                                            </span>
                                        </li>
                                        <?php endif; ?>
                                    </ul>

                                    <!-- Pengawas -->
                                    <div class="pengawas-box mx-3">
                                        <div class="pengawas-label">
                                            <i class="fas fa-user-shield"></i> Pengawas Ujian
                                        </div>
                                        <ul>
                                            <?php foreach ($pengawas as $pws) : ?>
                                                <li><?= $pws->nama_guru ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>

                                    <!-- Tombol Mulai -->
                                    <div class="text-center py-4">
                                        <button id="load-soal" type="submit" class="btn btn-success">
                                            <i class="fas fa-play-circle mr-2"></i>Mulai Ujian
                                        </button>
                                    </div>

                                    <?= form_close(); ?>

                                <?php elseif (!$valid) : ?>
                                    <div class="exam-alert-wrapper">
                                        <div class="exam-alert-icon exam-alert-icon--danger">
                                            <i class="fas fa-ban"></i>
                                        </div>
                                        <h4>Ujian Tidak Bisa Dilanjutkan</h4>
                                        <p>Anda tidak memiliki izin untuk mengikuti ujian ini saat ini.<br>Silakan hubungi <strong>Proktor / Admin</strong> untuk mendapatkan izin.</p>
                                        <small>Refresh halaman ini setelah mendapat izin dari proktor.</small>
                                        <button onclick="location.reload()" class="btn btn-outline-secondary btn-refresh">
                                            <i class="fas fa-sync-alt mr-1"></i> Refresh
                                        </button>
                                    </div>
                                <?php elseif (!$support) : ?>
                                    <div class="exam-alert-wrapper">
                                        <div class="exam-alert-icon exam-alert-icon--warning">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </div>
                                        <h4>Browser Tidak Didukung</h4>
                                        <p>Browser yang Anda gunakan tidak mendukung fitur ujian.<br>Gunakan <strong>Google Chrome</strong> atau <strong>Mozilla Firefox</strong> versi terbaru.</p>
                                        <small>Tutup browser ini dan buka kembali dengan browser yang didukung.</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url() ?>/assets/app/js/redirect.js"></script>
<script>
    $('#konfir').submit(function (e) {
        e.stopPropagation();
        e.preventDefault();

        swal.fire({
            title: "Membuka Soal",
            text: "Silahkan tunggu....",
            button: false,
            closeOnClickOutside: false,
            closeOnEsc: false,
            allowEscapeKey: false,
            allowOutsideClick: false,
            onOpen: () => {
                swal.showLoading();
            }
        });
        console.log($(this).serialize());
        var jadwal = $(this).find('input[name="jadwal"]').val();
        $.ajax({
            type: 'POST',
            url: base_url + 'siswa/validasisiswa',
            data: $(this).serialize(),
            success: function (data) {
                console.log(data);
                // jika menggunakan token, cek token
                if (data.token === true) {
                    // token ok
                    // cek browser dulu
                    if (data.support === false) {
                        // browser tidak support
                        // siswa stop disini
                        swal.fire({
                            "title": "Error",
                            "html": "Browser tidak mendukung!<br>Gunakan browser Chrome, atau Mozilla<br>005",
                            "icon": "error"
                        });
                    } else {
                        // browser OK
                        // cek izin ujian
                        if (data.izinkan === true) {
                            // diizinkan
                            // cek sisa waktu
                            if (data.ada_waktu === true) {
                                // masih ada waktu
                                // cek apakah ada soal?
                                if (data.jml_soal > 0) {
                                    // ada soal
                                    // siswa masuk halaman ujian
                                    window.location.href = base_url + 'siswa/penilaian/' + jadwal;
                                } else {
                                    // soal belum dibuat
                                    swal.fire({
                                        "title": "Error",
                                        "html": "Tidak ada soal ujian<br>Hubungi proktor<br>004",
                                        "icon": "error"
                                    });
                                }
                            } else {
                                // siswa logout ditengah ujian dan tidak melanjutkan sampai waktu ujian habis
                                // admin harus reset waktu
                                swal.fire({
                                    "title": "Error",
                                    "html": data.warn.msg + "<br>Hubungi proktor<br>003",
                                    "icon": "error"
                                });
                            }
                        } else {
                            // ditengah ujian, siswa ganti hape/komputer
                            // siswa tidak diizinkan ujian
                            // admin perlu reset izin
                            swal.fire({
                                "title": "Error",
                                "html": "Anda sedang mengerjakan ujian di perangkat lain<br>Hubungi proktor<br>002",
                                "icon": "error"
                            });
                        }
                    }
                } else {
                    // token salah, atau token tidak dibuat oleh admin
                    swal.fire({
                        "title": "Error",
                        "html": "TOKEN salah!<br>Hubungi proktor<br>001",
                        "icon": "error"
                    });
                }
            }, error: function (xhr, error, status) {
                swal.fire({
                    "title": "Error",
                    "html": "Coba kembali ke beranda, lalu ulangi lagi<br>006",
                    "icon": "error"
                });
                console.log(xhr.responseText);
            }
        });
    });

    console.log('mnt', getMinutes('2023-01-30 11:30:30'));

    function getMinutes(d) {
        var startTime = new Date(d);
        var endTime = new Date();
        endTime.setHours(endTime.getHours() - startTime.getHours());
        endTime.setMinutes(endTime.getMinutes() - startTime.getMinutes());
        endTime.setSeconds(endTime.getSeconds() - startTime.getSeconds());

        return {h: endTime.getHours(), m: endTime.getMinutes(), s: endTime.getSeconds()}
    }

</script>
