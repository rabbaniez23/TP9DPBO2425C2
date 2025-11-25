<?php
// === KONFIGURASI DAN INCLUDE ===
$dbHost = 'localhost';
$dbName = 'mvp_db';
$dbUser = 'root';
$dbPass = '';

include_once("models/DB.php");

// Includes Pembalap
include_once("models/TabelPembalap.php");
include_once("views/ViewPembalap.php");
include_once("presenters/PresenterPembalap.php");

// Includes Tim Balap
include_once("models/TabelTim.php");
include_once("views/ViewTim.php");
include_once("presenters/PresenterTim.php");

// === ROUTING & NAVIGASI ===
$nav = $_GET['nav'] ?? 'pembalap'; // Default menu

// Header HTML Sederhana
echo '<!DOCTYPE html><html lang="id"><head><title>Manajemen Balapan MVP</title>';
echo '<style>
        body { font-family: "Segoe UI", sans-serif; background: #f7f8fb; padding: 20px; color: #333; }
        .nav { background: #fff; padding: 15px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .nav a { margin-right: 20px; text-decoration: none; font-weight: 600; color: #555; }
        .nav a.active { color: #2563eb; border-bottom: 2px solid #2563eb; padding-bottom: 2px; }
      </style></head><body>';

// Menu Navigasi
echo '<div class="nav">';
echo '<a href="index.php?nav=pembalap" class="'.($nav=='pembalap'?'active':'').'">Data Pembalap</a>';
echo '<a href="index.php?nav=tim" class="'.($nav=='tim'?'active':'').'">Data Tim Balap</a>';
echo '</div>';


// === CONTROLLER LOGIC ===

if ($nav == 'pembalap') {
    // --- AREA PEMBALAP ---
    $model = new TabelPembalap($dbHost, $dbName, $dbUser, $dbPass);
    $view = new ViewPembalap();
    $presenter = new PresenterPembalap($model, $view);

    // Handle REQUEST POST (Add, Edit, DAN Delete dari JS Template)
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'] ?? '';
        
        if ($action == 'add') {
            $presenter->tambahPembalap($_POST['nama'], $_POST['tim'], $_POST['negara'], $_POST['poinMusim'], $_POST['jumlahMenang']);
        } 
        elseif ($action == 'edit') {
            $presenter->ubahPembalap($_POST['id'], $_POST['nama'], $_POST['tim'], $_POST['negara'], $_POST['poinMusim'], $_POST['jumlahMenang']);
        }
        elseif ($action == 'delete') {
            // [FIX] Handle Delete via POST (karena skin.html kirim via POST)
            $presenter->hapusPembalap($_POST['id']);
        }
        
        // Penting: Stop script setelah redirect header di presenter
        exit();
    } 
    // Handle REQUEST GET (Tampil List & Form)
    else {
        $screen = $_GET['screen'] ?? 'list';
        
        // Fallback: Handle delete via GET (jika ada link hapus biasa)
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $presenter->hapusPembalap($_GET['id']);
            exit();
        }

        if ($screen == 'add') {
            echo $presenter->tampilkanFormPembalap();
        } elseif ($screen == 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormPembalap($_GET['id']);
        } else {
            echo $presenter->tampilkanPembalap();
        }
    }

} else if ($nav == 'tim') {
    // --- AREA TIM BALAP ---
    $model = new TabelTim($dbHost, $dbName, $dbUser, $dbPass);
    $view = new ViewTim();
    $presenter = new PresenterTim($model, $view);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action == 'add') {
            $presenter->tambahTim($_POST['nama'], $_POST['prinsipal'], $_POST['markas'], $_POST['tahun']);
        } 
        elseif ($action == 'edit') {
            $presenter->ubahTim($_POST['id'], $_POST['nama'], $_POST['prinsipal'], $_POST['markas'], $_POST['tahun']);
        }
        elseif ($action == 'delete') {
            // [FIX] Handle Delete Tim via POST
            $presenter->hapusTim($_POST['id']);
        }
        exit();
    } else {
        $screen = $_GET['screen'] ?? 'list';
        
        if (isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['id'])) {
            $presenter->hapusTim($_GET['id']);
            exit();
        }

        if ($screen == 'add') {
            echo $presenter->tampilkanFormTim();
        } elseif ($screen == 'edit' && isset($_GET['id'])) {
            echo $presenter->tampilkanFormTim($_GET['id']);
        } else {
            echo $presenter->tampilkanListTim();
        }
    }
}

echo '</body></html>';
?>