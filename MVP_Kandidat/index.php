<?php
// Memanggil file Kandidat
require_once __DIR__ . '/models/TabelKandidat.php';
require_once __DIR__ . '/views/ViewKandidat.php';
require_once __DIR__ . '/presenters/PresenterKandidat.php';

// Memanggil file Departemen
require_once __DIR__ . '/departemen/models/TabelDepartemen.php';
require_once __DIR__ . '/departemen/views/ViewDepartemen.php';
require_once __DIR__ . '/departemen/presenters/PresenterDepartemen.php';

// Membuat objek Kandidat
$model = new TabelKandidat('localhost', 'mvp_kandidat_db', 'root', '');
$view = new ViewKandidat();
$presenter = new PresenterKandidat($model, $view);

// Membuat objek Departemen
$modelDepartemen = new TabelDepartemen('localhost', 'mvp_kandidat_db', 'root', '');
$viewDepartemen = new ViewDepartemen();
$presenterDepartemen = new PresenterDepartemen($modelDepartemen, $viewDepartemen);

// Menentukan menu yang dibuka
$menu = $_GET['menu'] ?? 'kandidat';

// Menangani request POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'] ?? '';

    // CRUD Departemen
    if ($menu === 'departemen') {

        if ($action === 'tambah') {
            $presenterDepartemen->tambahDepartemen(
                $_POST['nama_departemen'],
                $_POST['deskripsi']
            );

        } elseif ($action === 'ubah') {
            $presenterDepartemen->ubahDepartemen(
                (int)$_POST['id'],
                $_POST['nama_departemen'],
                $_POST['deskripsi']
            );

        } elseif ($action === 'hapus') {
            $presenterDepartemen->hapusDepartemen(
                (int)$_POST['id']
            );

        } else {
            header("Location: index.php?menu=departemen");
            exit();
        }

    } else {

        // CRUD Kandidat
        if ($action === 'tambah') {
            $presenter->tambahKandidat(
                $_POST['nama'],
                $_POST['posisi'],
                $_POST['domisili'],
                (int)$_POST['skorTes'],
                (int)$_POST['pengalamanTahun']
            );

        } elseif ($action === 'ubah') {
            $presenter->ubahKandidat(
                (int)$_POST['id'],
                $_POST['nama'],
                $_POST['posisi'],
                $_POST['domisili'],
                (int)$_POST['skorTes'],
                (int)$_POST['pengalamanTahun']
            );

        } elseif ($action === 'hapus') {
            $presenter->hapusKandidat((int)$_POST['id']);

        } else {
            header("Location: index.php");
            exit();
        }
    }

} else {

    // Menampilkan halaman Departemen
    if ($menu === 'departemen') {

        $screen = $_GET['screen'] ?? 'list';

        if ($screen === 'add') {
            echo $presenterDepartemen->tampilkanFormDepartemen();

        } elseif ($screen === 'edit' && isset($_GET['id'])) {
            echo $presenterDepartemen->tampilkanFormDepartemen(
                (int)$_GET['id']
            );

        } else {
            echo $presenterDepartemen->tampilkanDepartemen();
        }

    } else {

        // Menampilkan halaman Kandidat
        $screen = $_GET['screen'] ?? 'list';

        if ($screen === 'add') {
            echo $presenter->tampilkanFormKandidat();

        } elseif ($screen === 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormKandidat(
                (int)$_GET['id']
            );

        } else {
            echo $presenter->tampilkanKandidat();
        }
    }
}
?>
