<?php
include_once("models/KontrakTim.php");
include_once(__DIR__ . "/../models/TabelTim.php");
include_once(__DIR__ . "/../models/Tim.php");
include_once(__DIR__ . "/../views/ViewTim.php");

class PresenterTim implements KontrakPresenterTim {
    private $tabel;
    private $view;

    public function __construct($tabel, $view){
        $this->tabel = $tabel;
        $this->view = $view;
    }

    public function tampilkanListTim(): string {
        $rawData = $this->tabel->getAllTim();
        $listObj = [];
        // Konversi Array asosiatif dari DB ke Objek Tim
        foreach($rawData as $r){
            $listObj[] = new Tim($r['id'], $r['nama_tim'], $r['prinsipal'], $r['markas'], $r['tahun_berdiri']);
        }
        return $this->view->tampilListTim($listObj);
    }

    public function tampilkanFormTim($id = null): string {
        $data = $id ? $this->tabel->getTimById($id) : null;
        return $this->view->tampilFormTim($data);
    }

    public function tambahTim($nama, $prinsipal, $markas, $tahun): void {
        $this->tabel->addTim($nama, $prinsipal, $markas, $tahun);
        header("Location: index.php?nav=tim");
    }

    public function ubahTim($id, $nama, $prinsipal, $markas, $tahun): void {
        $this->tabel->updateTim($id, $nama, $prinsipal, $markas, $tahun);
        header("Location: index.php?nav=tim");
    }

    public function hapusTim($id): void {
        $this->tabel->deleteTim($id);
        header("Location: index.php?nav=tim");
    }
}
?>