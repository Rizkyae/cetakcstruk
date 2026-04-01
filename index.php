<?php
require_once 'TransferBank.php';
require_once 'EWallet.php';
require_once 'QRIS.php';

$pesan = "";
$struk = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jumlah = isset($_POST['jumlah']) ? (float)$_POST['jumlah'] : 0;
    $metode = $_POST['metode'];

    $pembayaran = null;

    if ($jumlah > 0) {
        switch ($metode) {
            case 'transfer':
                $pembayaran = new TransferBank($jumlah);
                break;
            case 'ewallet':
                $pembayaran = new EWallet($jumlah);
                break;
            case 'qris':
                $pembayaran = new QRIS($jumlah);
                break;
        }

        if ($pembayaran != null) {
            $pesan = $pembayaran->prosesPembayaran();
            $struk = $pembayaran->cetakStruk();
        }
    } else {
        $pesan = "⚠️ Masukkan nominal yang valid, bestie!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pembayaran Gen-Z</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; font-family: 'Poppins', sans-serif; margin: 0; padding: 0; }
        
        body {
            /* Animated Gradient Background */
            background: linear-gradient(-45deg, #ff9a9e, #fecfef, #a1c4fd, #c2e9fb);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glassmorphism Effect */
        .glass-panel {
            background: rgba(255, 255, 255, 0.4);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.5);
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.15);
        }

        h2 { text-align: center; margin-bottom: 25px; color: #2c3e50; font-weight: 600; }

        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-size: 14px; font-weight: 600; }
        
        input[type="number"], select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid rgba(255,255,255,0.6);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.5);
            font-size: 15px;
            outline: none;
            transition: all 0.3s ease;
        }

        input[type="number"]:focus, select:focus {
            background: rgba(255, 255, 255, 0.8);
            border-color: #a1c4fd;
            box-shadow: 0 0 10px rgba(161, 196, 253, 0.5);
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(118, 75, 162, 0.3);
        }

        /* Style Struk Hasil */
        .result-box {
            margin-top: 25px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 12px;
            animation: fadeIn 0.5s ease;
        }

        .alert-success {
            background: rgba(46, 204, 113, 0.2);
            color: #27ae60;
            padding: 10px;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .struk p { margin: 5px 0; font-size: 14px; display: flex; justify-content: space-between; }
        .struk h4 { margin-top: 15px; text-align: right; color: #8e44ad; }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="glass-panel">
    <h2>💸 PayFlow App</h2>
    
    <form method="POST" action="">
        <div class="form-group">
            <label for="jumlah">Nominal Pembayaran (Rp)</label>
            <input type="number" name="jumlah" id="jumlah" placeholder="Contoh: 150000" required>
        </div>

        <div class="form-group">
            <label for="metode">Metode Pembayaran</label>
            <select name="metode" id="metode" required>
                <option value="" disabled selected>Pilih cara bayar...</option>
                <option value="ewallet">E-Wallet (GoPay, OVO, Dana)</option>
                <option value="qris">QRIS (Scan Barcode)</option>
                <option value="transfer">Transfer Bank</option>
            </select>
        </div>

        <button type="submit">Bayar Sekarang 🚀</button>
    </form>

    <?php if (!empty($pesan)): ?>
        <div class="result-box">
            <div class="alert-success">
                <?= $pesan ?>
            </div>
            <?= $struk ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>