<style>
    :root {
        --primary: #1cc88a;
        --gradient: linear-gradient(135deg, #1cc88a 0%, #13855c 100%);
    }

    body, .login-page {
        margin: 0;
        padding: 0;
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        /* Modern Emerald Background Pattern */
        background-color: #f0fdf4 !important;
        background-image: url("data:image/svg+xml,%3Csvg width='80' height='80' viewBox='0 0 80 80' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%231cc88a' fill-opacity='0.03' fill-rule='evenodd'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 35c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm60-21c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM66 62c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm-48 5c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm63 31c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM34 90c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm56-76c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 86c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm28-65c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm23-11c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z'/%3E%3C/g%3E%3C/svg%3E") !important;
    }

    .login-container {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        padding: 20px;
    }

    .login-card {
        background: #ffffff;
        border-radius: 30px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.1);
        width: 100%;
        max-width: 420px;
        overflow: hidden;
        animation: fadeIn 0.8s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
        background: var(--gradient);
        padding: 3.5rem 2rem;
        text-align: center;
        color: #ffffff;
        position: relative;
    }

    .login-header::before {
        content: "";
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/svg%3E");
        opacity: 0.5;
    }

    .login-header img {
        width: 90px;
        height: 90px;
        border-radius: 20px;
        background: #fff;
        padding: 10px;
        margin-bottom: 1.5rem;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        position: relative;
        z-index: 1;
    }

    .login-header h4 {
        font-weight: 700;
        margin-bottom: 0.5rem;
        position: relative;
        z-index: 1;
    }

    .login-body {
        padding: 2.5rem;
    }

    .form-group-modern {
        margin-bottom: 1.5rem;
    }

    .input-group-modern {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
    }

    .input-group-modern:focus-within {
        border-color: var(--primary);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(28, 200, 138, 0.1);
    }

    .input-group-modern .input-icon {
        padding: 0 1.2rem;
        color: #94a3b8;
    }

    .input-group-modern input {
        border: none !important;
        background: transparent !important;
        padding: 1.1rem 1rem 1.1rem 0 !important;
        font-size: 0.95rem;
        width: 100%;
        outline: none;
    }

    .btn-login {
        background: var(--gradient);
        color: white;
        border: none;
        border-radius: 16px;
        padding: 1.1rem;
        width: 100%;
        font-weight: 600;
        font-size: 1rem;
        letter-spacing: 0.5px;
        margin-top: 1rem;
        box-shadow: 0 10px 20px rgba(28, 200, 138, 0.3);
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .btn-login:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 30px rgba(28, 200, 138, 0.4);
    }

    .icheck-primary label {
        color: #64748b;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
    }

    .login-footer {
        text-align: center;
        margin-top: 2rem;
        color: #94a3b8;
        font-size: 0.8rem;
    }
</style>

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
