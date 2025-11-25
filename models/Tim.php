<?php
class Tim {
    private $id;
    private $nama;
    private $prinsipal;
    private $markas;
    private $tahun;

    public function __construct($id, $nama, $prinsipal, $markas, $tahun){
        $this->id = $id;
        $this->nama = $nama;
        $this->prinsipal = $prinsipal;
        $this->markas = $markas;
        $this->tahun = $tahun;
    }

    public function getId(){ return $this->id; }
    public function getNama(){ return $this->nama; }
    public function getPrinsipal(){ return $this->prinsipal; }
    public function getMarkas(){ return $this->markas; }
    public function getTahun(){ return $this->tahun; }
}
?>