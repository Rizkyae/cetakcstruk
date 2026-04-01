<?php
#Penggunaan Abstrak Class
abstract class Pembayaran {
    protected $jumlah;
    protected $diskon = 0.10; // Diskon 10%
    protected $pajak = 0.11;  // Pajak 11%

    public function __construct($jumlah) {
        $this->jumlah = $jumlah;
    }

    // method wajib
    abstract public function prosesPembayaran();

    // method umum untuk menghitung rincian
    public function hitungRincian() {
        $nominalDiskon = $this->jumlah * $this->diskon;
        $hargaSetelahDiskon = $this->jumlah - $nominalDiskon;
        $nominalPajak = $hargaSetelahDiskon * $this->pajak;
        $totalBayar = $hargaSetelahDiskon + $nominalPajak;

        return [
            'subtotal' => $this->jumlah,
            'diskon' => $nominalDiskon,
            'pajak' => $nominalPajak,
            'total' => $totalBayar
        ];
    }

    public function validasi() {
        return $this->jumlah > 0;
    }
}
?>