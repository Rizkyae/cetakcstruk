<?php
require_once 'Pembayaran.php';
require_once 'Cetak.php';

class QRIS extends Pembayaran implements Cetak {
    public function prosesPembayaran() {
        if ($this->validasi()) {
            return "Scan <b>QRIS</b> berhasil! ✨";
        }
        return "Gagal! Jumlah tidak valid.";
    }

    public function cetakStruk() {
        $r = $this->hitungRincian();
        return "
            <div class='struk'>
                <p><b>Metode:</b> QRIS</p>
                <p><b>Subtotal:</b> Rp " . number_format($r['subtotal'], 0, ',', '.') . "</p>
                <p><b>Diskon (10%):</b> -Rp " . number_format($r['diskon'], 0, ',', '.') . "</p>
                <p><b>Pajak (11%):</b> +Rp " . number_format($r['pajak'], 0, ',', '.') . "</p>
                <hr style='border-color: rgba(255,255,255,0.2)'>
                <h4>Total Bayar: Rp " . number_format($r['total'], 0, ',', '.') . "</h4>
            </div>
        ";
    }
}
?>