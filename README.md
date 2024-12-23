# Sistem Manajemen Peralatan Medis

Sistem berbasis web untuk mengelola inventaris peralatan medis rumah sakit, catatan pemeliharaan, dan kontrol akses pengguna.

## Fitur

- Pelacakan peralatan dengan informasi detail
- Dukungan multi-pengguna dengan akses berbasis peran (Admin, Staf, Teknisi)
- Pemantauan status peralatan
- Penjadwalan dan pelacakan pemeliharaan
- Desain responsif untuk desktop dan mobile
- Sistem autentikasi yang aman

## Prasyarat

- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)
- Ekstensi PHP PDO
- Browser web modern

## Instalasi

1. Clone repositori atau unduh kode sumber
2. Buat database MySQL dan impor skema:
```sql
mysql -u root -p < database.sql
```

3. Konfigurasi koneksi database di `koneksi.php`:
```php
private $host = "localhost";
private $user = "username_anda";
private $pass = "password_anda";
private $dbname = "medical_equipment_db";
```

4. Pastikan izin file yang tepat:
```bash
chmod 755 -R /path/ke/projek
chmod 777 -R /path/ke/projek/uploads
```

5. Konfigurasi web server untuk mengarah ke direktori projek

## Struktur Database

### Tabel Users
- id (Kunci Utama)
- username (Unik)
- email (Unik)
- password (Terenkripsi)
- full_name
- phone_number
- department
- role (admin/staff/technician)
- join_date

### Tabel Medical Equipment
- id (Kunci Utama)
- equipment_code (Unik)
- name
- category
- manufacturer
- purchase_date
- warranty_expiry
- maintenance_status
- location
- last_inspection_date
- notes

## Struktur File

- `index.php` - Titik masuk dan routing
- `login.php` - Antarmuka autentikasi pengguna
- `register.php` - Pendaftaran pengguna baru
- `cms.php` - Dashboard utama manajemen peralatan
- `koneksi.php` - Koneksi dan operasi database
- `proses.php` - Pemrosesan form dan autentikasi
- `logout.php` - Terminasi sesi
- `styles.css` - Styling aplikasi

## Fitur Keamanan

- Enkripsi password menggunakan password_hash() PHP
- Autentikasi berbasis sesi
- PDO prepared statements untuk pencegahan SQL injection
- Validasi dan sanitasi input
- Kontrol akses berbasis peran

## Penggunaan

1. Daftar akun baru dengan peran yang sesuai
2. Masuk menggunakan kredensial
3. Akses dashboard untuk mengelola peralatan:
   - Tambah peralatan baru
   - Edit catatan yang ada
   - Perbarui status pemeliharaan
   - Lihat detail peralatan
   - Hapus catatan peralatan

## Kontribusi

1. Fork repositori
2. Buat branch fitur
3. Commit perubahan
4. Push ke branch
5. Buat pull request

## Lisensi

Projek ini dilisensikan di bawah Lisensi MIT.

## Dukungan

Untuk dukungan dan pertanyaan, silakan buka issue di repositori atau hubungi administrator sistem.
