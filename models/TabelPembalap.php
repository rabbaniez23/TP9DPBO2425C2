<?php

include_once ("models/DB.php");
include_once ("KontrakModel.php");

class TabelPembalap extends DB implements KontrakModel {

    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    // Mengambil semua data dari tabel pembalap
    public function getAllPembalap(): array {
        $query = "SELECT * FROM pembalap"; 
        $this->executeQuery($query);
        return $this->getAllResult();
    }

    // Mengambil data berdasarkan ID (untuk edit)
    public function getPembalapById($id): ?array {
        $query = "SELECT * FROM pembalap WHERE id = :id";
        $this->executeQuery($query, [':id' => $id]);
        $data = $this->getAllResult();
        return count($data) > 0 ? $data[0] : null;
    }

    // [DIPERBAIKI] Method Insert Data
    public function addPembalap($nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        // Query SQL untuk menyimpan data
        $query = "INSERT INTO pembalap (nama, tim, negara, poinMusim, jumlahMenang) VALUES (:nama, :tim, :negara, :poin, :menang)";
        
        // Binding parameter agar aman dari SQL Injection
        $this->executeQuery($query, [
            ':nama' => $nama,
            ':tim' => $tim,
            ':negara' => $negara,
            ':poin' => $poinMusim,
            ':menang' => $jumlahMenang
        ]);
    }

    // [DIPERBAIKI] Method Update Data
    public function updatePembalap($id, $nama, $tim, $negara, $poinMusim, $jumlahMenang): void {
        // Query SQL untuk update data berdasarkan ID
        $query = "UPDATE pembalap SET nama=:nama, tim=:tim, negara=:negara, poinMusim=:poin, jumlahMenang=:menang WHERE id=:id";
        
        $this->executeQuery($query, [
            ':nama' => $nama,
            ':tim' => $tim,
            ':negara' => $negara,
            ':poin' => $poinMusim,
            ':menang' => $jumlahMenang,
            ':id' => $id
        ]);
    }

    // [DIPERBAIKI] Method Delete Data
    public function deletePembalap($id): void {
        // Query SQL untuk menghapus data berdasarkan ID
        $query = "DELETE FROM pembalap WHERE id = :id";
        
        $this->executeQuery($query, [':id' => $id]);
    }
}

?>