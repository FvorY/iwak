<?php

function FormatRupiah($angka) {
  $number = "Rp. " . number_format($angka,2,',','.');

  return $number;
}

function FormatRupiahFront($angka) {
  $number = "Rp. " . number_format($angka,0,',','.');

  return $number;
}
