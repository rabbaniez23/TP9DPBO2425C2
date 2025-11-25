<?php

include_once(__DIR__ . "/KontrakPresenter.php");
include_once(__DIR__ . "/../models/TabelPembalap.php");
include_once(__DIR__ . "/../models/Pembalap.php");
include_once(__DIR__ . "/../views/ViewPembalap.php");

class PresenterPembalap implements KontrakPresenter
{
    private $tabelPembalap;
    private $viewPembalap;
    private $listPembalap = [];

    public function __construct($tabelPembalap, $viewPembalap)
    {
        $this->tabelPembalap = $tabelPembalap;
        $this->viewPembalap = $viewPembalap;
    }

    public function initListPembalap()
    {
        $dataList = $this->tabelPembalap->getAllPembalap();
        $this->listPembalap = []; 

        foreach($dataList as $row) {
            // Note: Pastikan key array ($row['...']) sesuai dengan kolom DB
            // Jika DB pakai snake_case (poin_musim), ubah di sini.
            $this->listPembalap[] = new Pembalap(
                $row['id'],
                $row['nama'],
                $row['tim'],
                $row['negara'],
                $row['poinMusim'],    // Sesuaikan dengan nama kolom DB
                $row['jumlahMenang']  // Sesuaikan dengan nama kolom DB
            );
        }
    }

    public function tampilkanPembalap(): string
    {
        $this->initListPembalap();
        return $this->viewPembalap->tampilPembalap($this->listPembalap);
    }

    public function tampilkanFormPembalap($id = null): string
    {
        $data = null;
        if($id != null){
            $data = $this->tabelPembalap->getPembalapById($id);
        }
        return $this->viewPembalap->tampilFormPembalap($data);
    }

    // [DIPERBAIKI] Method CRUD sekarang ada isinya!
    public function tambahPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void 
    {
        $this->tabelPembalap->addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang);
        // Redirect pakai nav=pembalap
        header("Location: index.php?nav=pembalap");
    }

    public function ubahPembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void 
    {
        $this->tabelPembalap->updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang);
        header("Location: index.php?nav=pembalap");
    }

    public function hapusPembalap($id): void 
    {
        $this->tabelPembalap->deletePembalap($id);
        header("Location: index.php?nav=pembalap");
    }
}
?>