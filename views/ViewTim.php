<?php
include_once(__DIR__ . "/../models/KontrakTim.php");
include_once(__DIR__ . "/../models/Tim.php");

class ViewTim implements KontrakViewTim {
    
    // Method untuk menampilkan List menggunakan skin.html
    public function tampilListTim($listTim): string {
        $rows = "";
        $no = 1;
        
        foreach($listTim as $tim){
            $rows .= "<tr>";
            $rows .= "<td class='col-id'>{$no}</td>";
            $rows .= "<td>" . htmlspecialchars($tim->getNama()) . "</td>";
            $rows .= "<td>" . htmlspecialchars($tim->getPrinsipal()) . "</td>";
            $rows .= "<td>" . htmlspecialchars($tim->getMarkas()) . "</td>";
            $rows .= "<td>" . htmlspecialchars($tim->getTahun()) . "</td>";
            
            $rows .= "<td class='col-actions'>
                <a href='index.php?nav=tim&screen=edit&id={$tim->getId()}' class='btn btn-edit'>Edit</a>
                <button data-id='{$tim->getId()}' class='btn btn-delete'>Hapus</button>
            </td>";
            $rows .= "</tr>";
            $no++;
        }
        
        $template = file_get_contents(__DIR__ . '/../template/skin.html');

        // Replace Judul
        $template = str_replace('Daftar Pembalap', 'Daftar Tim Balap', $template);
        
        // [FIX] Ganti Label Tombol (Biar tulisannya jadi Tambah Tim, bukan Pembalap)
        $template = str_replace('+ Tambah Pembalap', '+ Tambah Tim', $template);
        
        // Ganti Link Tombol Tambah
        $template = str_replace('index.php?screen=add', 'index.php?nav=tim&screen=add', $template);
        
        // Ganti Header Tabel
        $oldHeader = '<th>Nama</th>
              <th>Tim</th>
              <th>Negara</th>
              <th>Poin Musim</th>
              <th>Jumlah Menang</th>'; // Pastikan string ini cocok, atau replace manual satu-satu seperti kemarin
              
        // Replace Header Manual (Lebih aman)
        $template = str_replace('<th>Tim</th>', '<th>Prinsipal</th>', $template);
        $template = str_replace('<th>Negara</th>', '<th>Markas</th>', $template);
        $template = str_replace('<th>Poin Musim</th>', '<th>Tahun Berdiri</th>', $template);
        $template = str_replace('<th>Jumlah Menang</th>', '', $template); 

        $template = str_replace("form.action = 'index.php';", "form.action = 'index.php?nav=tim';", $template);

        // [FIX UTAMA] Ubah cara inject baris data
        // Jangan cari komentar HTML, tapi cari tag penutup </tbody>
        // Kita selipkan baris data tepat SEBELUM tag </tbody>
        $template = str_replace('</tbody>', $rows . '</tbody>', $template);
        
        $template = str_replace('Total:', 'Total: ' . count($listTim), $template);

        return $template;
    }

    // Method untuk menampilkan Form menggunakan form.html
    public function tampilFormTim($data = null): string {
        // 1. Ambil isi file template form.html
        $template = file_get_contents(__DIR__ . '/../template/form.html');
        
        // 2. Siapkan Data
        $idVal = $data['id'] ?? '';
        $action = $data ? 'edit' : 'add';
        $nama = $data['nama_tim'] ?? '';
        $prinsipal = $data['prinsipal'] ?? '';
        $markas = $data['markas'] ?? '';
        $tahun = $data['tahun_berdiri'] ?? '';

        // 3. Replace Data Dasar
        $template = str_replace('Form Pembalap', 'Form Tim Balap', $template);
        $template = str_replace('value="add"', 'value="'.$action.'"', $template);
        $template = str_replace('value="" id="pembalap-id"', 'value="'.$idVal.'" id="pembalap-id"', $template);
        // Ganti action form agar mengarah ke nav=tim
        $template = str_replace('action="index.php"', 'action="index.php?nav=tim"', $template);
        $template = str_replace('href="index.php"', 'href="index.php?nav=tim"', $template);

        // 4. Replace Input Fields (Trik mengganti input Pembalap jadi Tim)
        
        // INPUT 1: Nama -> Nama Tim
        $template = str_replace('placeholder="Nama pembalap"', 'placeholder="Nama Tim" value="'.$nama.'"', $template);
        
        // INPUT 2: Tim -> Prinsipal
        // Kita ganti labelnya
        $template = str_replace('<label for="tim">Tim</label>', '<label for="prinsipal">Prinsipal</label>', $template);
        // Kita ganti atribut inputnya (name="tim" jadi name="prinsipal")
        $template = str_replace('name="tim"', 'name="prinsipal" value="'.$prinsipal.'"', $template);
        $template = str_replace('placeholder="Nama tim"', 'placeholder="Nama Prinsipal"', $template);

        // INPUT 3: Negara -> Markas
        $template = str_replace('<label for="negara">Negara</label>', '<label for="markas">Markas</label>', $template);
        $template = str_replace('name="negara"', 'name="markas" value="'.$markas.'"', $template);
        $template = str_replace('placeholder="Negara (mis. Indonesia)"', 'placeholder="Lokasi Markas"', $template);

        // INPUT 4: Poin Musim -> Tahun Berdiri
        $template = str_replace('<label for="poinMusim">Poin Musim</label>', '<label for="tahun">Tahun Berdiri</label>', $template);
        $template = str_replace('name="poinMusim"', 'name="tahun" value="'.$tahun.'"', $template);

        // INPUT 5: Jumlah Menang -> HAPUS (Tim tidak pakai ini di form)
        // Kita hapus blok div yang membungkus input jumlahMenang
        // Karena agak sulit menghapus blok HTML multiline dengan str_replace biasa, 
        // kita cari penanda unik di form.html kamu (class="full")
        $stringHapus = '<div class="full">
          <label for="jumlahMenang">Jumlah Menang</label>
          <input id="jumlahMenang" name="jumlahMenang" type="number" min="0" step="1" placeholder="0" data-field>
        </div>';
        // Hapus dengan replace string kosong. 
        // CATATAN: Spasi/enter di $stringHapus harus SAMA PERSIS dengan di file form.html.
        // Jika tidak yakin, kita gunakan Regex sederhana untuk menghapus bagian tersebut:
        $template = preg_replace('/<div class="full">\s*<label for="jumlahMenang".*?<\/div>/s', '', $template);

        return $template;
    }
}
?>