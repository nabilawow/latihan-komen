<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$file = 'data_komentar.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = strip_tags($_POST['nama']);
    $komentar = strip_tags($_POST['komentar']);
    $tanggal = date('Y-m-d H:i:s');

    $data = [
        'nama' => $nama,
        'komentar' => $komentar,
        'tanggal' => $tanggal
    ];

    file_put_contents($file, json_encode($data) . PHP_EOL, FILE_APPEND);
    echo json_encode(['status' => 'sukses']);
    exit;
} else {
    $komentarList = [];
    if (file_exists($file)) {
        $baris = file($file, FILE_IGNORE_NEW_LINES);
        foreach ($baris as $b) {
            $decoded = json_decode($b, true);
            if ($decoded) {
                $komentarList[] = $decoded;
            }
        }
    }

    header('Content-Type: application/json');
    echo json_encode(array_reverse($komentarList));
}
?>
