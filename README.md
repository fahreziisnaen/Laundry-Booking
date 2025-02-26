# 🧺 AZZAHRA LAUNDRY MANAGEMENT SYSTEM
Sistem manajemen laundry modern yang dibangun dengan Laravel, dilengkapi fitur manajemen booking, tracking status secara real-time, dan manajemen pelanggan.
## ✨ FITUR UTAMA
- 📅 Manajemen Booking Laundry
- 🔍 Tracking Pesanan Real-time
- 📊 Dashboard Customer & Admin
- 🚚 Manajemen Pickup/Delivery
- 💰 Manajemen Paket & Harga
- 🔔 Update Status & Notifikasi
## 🛠️ TEKNOLOGI YANG DIGUNAKAN
- 🔥 Laravel 10.x
- 🗄️ MySQL/MariaDB
- 🎨 Tailwind CSS
- ⚡ Livewire
- 🏔️ Alpine.js
- 🚀 Jetstream
## 📋 PERSYARATAN SISTEM
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL/MariaDB
## 📥 CARA INSTALASI
1. **Clone repository**
   ```bash
   git clone https://github.com/fahreziisnaen/Laundry-Booking.git
   cd Laundry-Booking
   ```
2. **Install dependensi PHP**
   ```bash
   composer install
   ```
3. **Install dependensi NPM**
   ```bash
   npm install
   ```
4. **Buat file environment**
   ```bash
   cp .env.example .env
   ```
5. **Generate application key**
   ```bash
   php artisan key:generate
   ```
6. **Konfigurasi database di .env**
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=azzahra_laundry
   DB_USERNAME=root
   DB_PASSWORD=
   ```
7. **Jalankan migrasi database**
   ```bash
   php artisan migrate
   ```
8. **Buat symbolic link untuk storage**
   ```bash
   php artisan storage:link
   ```
9. **Set permission dan ownership (untuk server production)**
   ```bash
   sudo chown -R www-data:www-data /var/www/Laundry-Booking
   sudo chmod -R 755 /var/www/Laundry-Booking
   sudo chmod -R 775 /var/www/Laundry-Booking/storage
   sudo chmod -R 775 /var/www/Laundry-Booking/bootstrap/cache
   ```
10. **Build assets untuk production**
    ```bash
    npm run build
    ```
11. **Jalankan development server**
    ```bash
    php artisan serve
    ```
## 👨‍💻 SETUP PENGEMBANGAN
1. **Buat user admin**
   ```php
   php artisan tinker
   
   User::create([
       'name' => 'Admin',
       'email' => 'admin@example.com',
       'password' => Hash::make('password'),
       'role' => 'admin'
   ]);
   ```
2. **Tambahkan paket laundry awal**
   ```bash
   php artisan db:seed --class=PackageSeeder
   ```
## 📁 STRUKTUR FOLDER
```
azzahra-laundry/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   └── Livewire/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   ├── views/
│   │   ├── bookings/
│   │   ├── layouts/
│   │   └── livewire/
│   ├── css/
│   └── js/
└── routes/
    └── web.php
```
## 📄 LISENSI
Proyek ini dilisensikan di bawah Lisensi MIT
## 📬 KONTAK
📧 Email: fahreziisnaen21@gmail.com  
🔗 Project Link: https://github.com/fahreziisnaen/Laundry-Booking/