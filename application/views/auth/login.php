<?php /* Fase 6: CSS login dipindahkan ke assets/app/css/login-style.css */ ?>

<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <?php $logo_app = $setting->logo_kanan == null ? base_url() . 'assets/img/favicon.png' : base_url() . $setting->logo_kanan; ?>
            <img src="<?= $logo_app ?>" alt="Logo">
            <h4><?= $setting->nama_aplikasi ?></h4>
            <p class="small mb-0 opacity-75"><?= $setting->alamat ?></p>
        </div>
        <div class="login-body">
            <div id="infoMessage" class="text-center mb-4"></div>

            <?= form_open("auth/cek_login", array('id' => 'login')); ?>
                <div class="form-group-modern">
                    <div class="input-group-modern">
                        <div class="input-icon"><i class="fas fa-user"></i></div>
                        <?= form_input($identity, '', 'placeholder="Username" required autocomplete="off"'); ?>
                    </div>
                </div>

                <div class="form-group-modern">
                    <div class="input-group-modern">
                        <div class="input-icon"><i class="fas fa-lock"></i></div>
                        <?= form_input($password, '', 'placeholder="Password" required id="password"'); ?>
                        <div class="input-icon" id="toggle-password" style="cursor:pointer"><i class="fas fa-eye-slash"></i></div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="icheck-primary">
                        <input type="checkbox" id="cbt-only" name="cbt-only" value="1" checked>
                        <label for="cbt-only">Mode Ujian (CBT Only)</label>
                    </div>
                </div>

                <button type="submit" id="submit" class="btn-login">MASUK KE SISTEM</button>
            <?= form_close(); ?>

            <div class="login-footer">
                &copy; <?= date('Y') ?> <?= $setting->nama_aplikasi ?> <br>
                <span class="small">Modern Software Experience</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $('form#login').on('submit', function(e){
            e.preventDefault();
            var btnsubmit = $('#submit');
            var infobox = $('#infoMessage');

            btnsubmit.attr('disabled', 'disabled').text('MEMVALIDASI...');
            infobox.html('<div class="alert alert-info py-2 small">Tunggu sebentar...</div>');

            localStorage.setItem('garudaCBT.login', $('#cbt-only').is(':checked') ? '1' : '0');

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: $(this).serialize(),
                success: function(data){
                    if(data.status){
                        infobox.html('<div class="alert alert-success py-2 small">Login Berhasil!</div>');
                        let go = '<?=base_url();?>' + data.url;
                        if (localStorage.getItem('garudaCBT.login') === '1' && data.role === 'siswa') {
                            go = '<?=base_url();?>' + 'siswa/cbt';
                        }
                        window.location.href = go;
                    } else {
                        btnsubmit.removeAttr('disabled').text('MASUK KE SISTEM');
                        infobox.html('<div class="alert alert-danger py-2 small">' + (data.failed || 'Akses ditolak') + '</div>');
                    }
                }
            });
        });

        $('#toggle-password').on('click', function () {
            const pass = $('#password');
            const type = pass.attr('type') === 'password' ? 'text' : 'password';
            pass.attr('type', type);
            $(this).find('i').toggleClass('fa-eye-slash fa-eye');
        });
    });
</script>
