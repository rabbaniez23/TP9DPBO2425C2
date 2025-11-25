# 🏎️ Aplikasi Manajemen Balapan (MVP Architecture)

Halo! Selamat datang di repositori tugas praktikum DPBO (Desain Pemrograman Berorientasi Objek).

Proyek ini adalah aplikasi web sederhana untuk mengelola data **Pembalap F1** dan **Tim Balap**. Aplikasi ini dibuat menggunakan PHP Native dengan menerapkan pola arsitektur **MVP (Model-View-Presenter)**. Tujuannya adalah memisahkan logika database, tampilan, dan alur program agar kode lebih rapi, terstruktur, dan mudah dikembangkan.

---

## 🚀 Fitur Utama

Aplikasi ini memiliki fitur **CRUD (Create, Read, Update, Delete)** lengkap untuk dua entitas utama:

1.  **Data Pembalap 🏁**
    * Melihat daftar pembalap, tim, poin, dan jumlah kemenangan.
    * Menambah pembalap baru.
    * Mengedit data pembalap.
    * Menghapus pembalap.

2.  **Data Tim Balap 🏎️**
    * Melihat daftar tim, prinsipal (ketua tim), markas, dan tahun berdiri.
    * Menambah, mengedit, dan menghapus data tim.

---

## 🛠️ Arsitektur MVP (Model-View-Presenter)

Agar kode tidak "spaghetti" (berantakan), proyek ini dibagi menjadi tiga lapisan utama:

* **📂 Model (`/models`)**:
    * Otak di balik data. Bertugas ngobrol langsung sama Database (MySQL).
    * Isinya query SQL (`SELECT`, `INSERT`, `UPDATE`, `DELETE`).
    * Contoh: `TabelPembalap.php`, `TabelTim.php`.

* **📂 View (`/views`)**:
    * Wajah aplikasi. Bertugas menampilkan HTML ke pengguna.
    * View **tidak boleh** ada logika bisnis, dia cuma terima data dan menampilkannya.
    * Menggunakan sistem *templating* sederhana (`skin.html` & `form.html`) agar desain konsisten.

* **📂 Presenter (`/presenters`)**:
    * Perantara (Jembatan). Dia yang menyuruh Model ambil data, lalu menyerahkannya ke View.
    * Logic tombol "Simpan", "Hapus", atau navigasi diurus di sini.

---

## 📂 Struktur Folder

```bash
📦 project-root
 ┣ 📂 models          # Koneksi DB dan Query SQL
 ┣ 📂 views           # Mengurus tampilan HTML
 ┣ 📂 presenters      # Logika penghubung
 ┣ 📂 template        # File HTML mentah (Skin & Form)
 ┣ 📜 index.php       # Pintu masuk utama (Router)
 ┗ 📜 README.md       # Dokumentasi ini
