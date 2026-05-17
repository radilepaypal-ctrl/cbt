<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Database Error - GarudaCBT</title>
    <link rel="stylesheet" href="<?php echo config_item('base_url'); ?>assets/adminlte/dist/css/poppins.css">
    <style type="text/css">
        :root {
            --primary: #1cc88a;
            --primary-dark: #13855c;
            --bg: #f7fafc;
            --text-main: #4a5568;
            --text-muted: #718096;
            --danger: #e74a3b;
        }

        body {
            background-color: var(--bg);
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
            color: var(--text-main);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            background-image:
                radial-gradient(circle, rgba(231,74,59,0.1) 1.5px, transparent 1.5px),
                radial-gradient(ellipse at 95% 10%, rgba(231,74,59,0.1) 0%, transparent 55%),
                radial-gradient(ellipse at 8% 90%, rgba(231,74,59,0.05) 0%, transparent 50%);
            background-size: 22px 22px, 100% 100%, 100% 100%;
        }

        .error-container {
            text-align: center;
            background: #fff;
            padding: 3rem 2.5rem;
            border-radius: 24px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            max-width: 500px;
            width: 90%;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(231, 74, 59, 0.1);
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0; left: 0; right: 0;
            height: 6px;
            background: linear-gradient(90deg, #f6c23e, var(--danger));
        }

        h1.error-code {
            font-size: 3rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, #f6c23e, var(--danger));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1.2;
            letter-spacing: -1px;
        }

        h2.error-heading {
            font-size: 1.2rem;
            color: var(--text-main);
            margin: 1rem 0 0.5rem;
            font-weight: 600;
        }

        p.error-msg {
            color: var(--text-muted);
            margin-bottom: 2rem;
            line-height: 1.6;
            font-size: 0.95rem;
        }
        
        .error-details {
            text-align: left;
            background: #f8fafc;
            padding: 1rem;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            font-size: 0.85rem;
            font-family: monospace;
            color: #64748b;
            margin-bottom: 2rem;
            overflow-x: auto;
        }

        .btn-home {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: #fff;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(28, 200, 138, 0.3);
        }

        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(28, 200, 138, 0.4);
            background: var(--primary-dark);
        }

        .btn-home:active {
            transform: translateY(1px);
        }
        
        .floating-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.1); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="floating-icon">💽</div>
        <h1 class="error-code">Database Error</h1>
        <h2 class="error-heading"><?php echo $heading; ?></h2>
        <div class="error-details">
            <?php echo strip_tags($message); ?>
        </div>
        <a href="javascript:history.back()" class="btn-home">Kembali ke Halaman Sebelumnya</a>
    </div>
</body>
</html>