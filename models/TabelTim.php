<?php
include_once ("models/DB.php");
include_once ("KontrakTim.php");

class TabelTim extends DB implements KontrakModelTim {
    public function __construct($host, $db_name, $username, $password) {
        parent::__construct($host, $db_name, $username, $password);
    }

    public function getAllTim(): array {
        $this->executeQuery("SELECT * FROM tim_balap");
        return $this->getAllResult();
    }

    public function getTimById($id): ?array {
        $this->executeQuery("SELECT * FROM tim_balap WHERE id=:id", [':id'=>$id]);
        $data = $this->getAllResult();
        return $data[0] ?? null;
    }

    public function addTim($nama, $prinsipal, $markas, $tahun): void {
        $query = "INSERT INTO tim_balap (nama_tim, prinsipal, markas, tahun_berdiri) VALUES (:nm, :pr, :mk, :th)";
        $this->executeQuery($query, [
            ':nm' => $nama, ':pr' => $prinsipal, 
            ':mk' => $markas, ':th' => $tahun
        ]);
    }

    public function updateTim($id, $nama, $prinsipal, $markas, $tahun): void {
        $query = "UPDATE tim_balap SET nama_tim=:nm, prinsipal=:pr, markas=:mk, tahun_berdiri=:th WHERE id=:id";
        $this->executeQuery($query, [
            ':nm' => $nama, ':pr' => $prinsipal, 
            ':mk' => $markas, ':th' => $tahun, ':id' => $id
        ]);
    }

    public function deleteTim($id): void {
        $this->executeQuery("DELETE FROM tim_balap WHERE id=:id", [':id'=>$id]);
    }
}
?>