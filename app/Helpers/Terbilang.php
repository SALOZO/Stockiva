<?php

if (!function_exists('terbilang')) {
    function terbilang($angka)
    {
        $angka = (float)$angka;
        $bilangan = ['', 'Satu', 'Dua', 'Tiga', 'Empat', 'Lima', 'Enam', 'Tujuh', 'Delapan', 'Sembilan', 'Sepuluh', 'Sebelas'];

        if ($angka < 12) {
            return $bilangan[$angka];
        } elseif ($angka < 20) {
            return $bilangan[$angka - 10] . ' Belas';
        } elseif ($angka < 100) {
            $puluh = floor($angka / 10);
            $sisa = $angka % 10;
            return $bilangan[$puluh] . ' Puluh ' . terbilang($sisa);
        } elseif ($angka < 200) {
            return 'Seratus ' . terbilang($angka - 100);
        } elseif ($angka < 1000) {
            $ratus = floor($angka / 100);
            $sisa = $angka % 100;
            return $bilangan[$ratus] . ' Ratus ' . terbilang($sisa);
        } elseif ($angka < 2000) {
            return 'Seribu ' . terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            $ribu = floor($angka / 1000);
            $sisa = $angka % 1000;
            return terbilang($ribu) . ' Ribu ' . terbilang($sisa);
        } elseif ($angka < 1000000000) {
            $juta = floor($angka / 1000000);
            $sisa = $angka % 1000000;
            return terbilang($juta) . ' Juta ' . terbilang($sisa);
        }
    }
}