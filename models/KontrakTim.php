<?php
// Kontrak untuk View
interface KontrakViewTim {
    public function tampilListTim($listTim): string;
    public function tampilFormTim($data = null): string;
}

// Kontrak untuk Presenter
interface KontrakPresenterTim {
    public function tampilkanListTim(): string;
    public function tampilkanFormTim($id = null): string;
    public function tambahTim($nama, $prinsipal, $markas, $tahun): void;
    public function ubahTim($id, $nama, $prinsipal, $markas, $tahun): void;
    public function hapusTim($id): void;
}

// Kontrak untuk Model
interface KontrakModelTim {
    public function getAllTim(): array;
    public function getTimById($id): ?array;
    public function addTim($nama, $prinsipal, $markas, $tahun): void;
    public function updateTim($id, $nama, $prinsipal, $markas, $tahun): void;
    public function deleteTim($id): void;
}
?>