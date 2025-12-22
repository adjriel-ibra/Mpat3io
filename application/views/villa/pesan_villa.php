<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Sekarang - Villa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Poppins', sans-serif;
        }

        .header-orange {
            background-color: #FF6B35;
        }

        .text-center-header {
            color: #fff;
            font-weight: bold;
        }

        .section-card {
            background: #fff;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: 700;
            border-left: 5px solid #FF6B35;
            padding-left: 15px;
        }

        .price-row {
            display: flex;
            justify-content: space-between;
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            font-weight: 800;
            color: #FF6B35;
        }

        .btn-bayar {
            background-color: #FF6B35;
            color: #fff;
            border-radius: 12px;
            width: 100%;
            padding: 15px;
            border: none;
            font-weight: 600;
        }
        
        .btn-bayar:hover {
            background-color: #e55a2b;
            color: #fff;
        }
    </style>
</head>

<body>

    <div class="header-orange p-4">
        <h2 class="text-center-header">Konfirmasi Pesanan</h2>
    </div>

    <main class="container py-4 mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <form id="formPemesanan" action="<?= base_url('user/dashboard/proses_bayar') ?>" method="POST">
                    <input type="hidden" name="id_villa" value="<?= $villa['id_villa'] ?>">
                    <input type="hidden" name="harga_villa" id="hargaDasar" value="<?= $villa['harga'] ?>">
                    

                    <div class="section-card">
                        <div class="section-title">Data Penyewa</div>
                        <input class="form-control mb-2" value="<?= $user['nama_penyewa'] ?>" readonly>
                        <input class="form-control mb-2" value="<?= $user['email_penyewa'] ?>" readonly>
                        <input class="form-control" value="<?= $user['no_telp'] ?>" readonly>
                    </div>

                    <div class="section-card">
                        <div class="section-title">Detail Waktu Inap</div>
                        <input type="date" name="tgl_check_in" id="checkin" class="form-control mb-2" required>
                        <input type="date" name="tgl_check_out" id="checkout" class="form-control" required>
                        <small>Total Durasi: <span id="totalHari">0</span> malam</small>
                    </div>

                    <div class="section-card">
                        <div class="section-title">Rincian Biaya</div>
                        <div class="price-row">
                            <span>Total Hari</span>
                            <span id="displayTotalHari">0 Malam</span>
                        </div>
                        <div class="total-row">
                            <span>Total</span>
                            <span id="grandTotal">Rp 0</span>
                        </div>
                    </div>

                    <button type="button" id="btnLanjut" class="btn btn-bayar">Pesan Sekarang</button>
                </form>

            </div>
        </div>
    </main>
    <script>
        const form = document.getElementById('formPemesanan');
        const checkin = document.getElementById('checkin');
        const checkout = document.getElementById('checkout');
        const totalHari = document.getElementById('totalHari');
        const displayTotalHari = document.getElementById('displayTotalHari');
        const grandTotal = document.getElementById('grandTotal');
        const btnLanjut = document.getElementById('btnLanjut');

        const harga = parseInt(document.getElementById('hargaDasar').value);
        const biaya = 100000; // Biaya admin/tambahan (sesuai kode awal)

        // Fungsi Hitung Hari dan Biaya
        function hitungTotal() {
            if (checkin.value && checkout.value) {
                const inDate = new Date(checkin.value);
                const outDate = new Date(checkout.value);

                if (outDate <= inDate) {
                    Swal.fire('Error', 'Checkout harus setelah checkin', 'error');
                    checkout.value = '';
                    return;
                }

                const hari = Math.ceil((outDate - inDate) / 86400000);
                const total = (harga * hari) + biaya;

                totalHari.innerText = hari;
                displayTotalHari.innerText = hari + ' Malam';
                grandTotal.innerText = 'Rp ' + total.toLocaleString('id-ID');
            }
        }

        checkin.addEventListener('change', hitungTotal);
        checkout.addEventListener('change', hitungTotal);

        // LOGIKA TOMBOL & SWEETALERT
        btnLanjut.addEventListener('click', function() {
            // 1. Validasi Tanggal dulu
            if (!checkin.value || !checkout.value) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Tanggal Belum Lengkap',
                    text: 'Silakan isi tanggal check-in dan check-out terlebih dahulu.'
                });
                return;
            }

            Swal.fire({
                title: 'Informasi Pembayaran',
                text: "Tunjukkan detail pemesanan jika ingin melakukan pembayaran offline.",
                icon: 'info',
                confirmButtonColor: '#FF6B35', // Warna oranye
                confirmButtonText: 'Oke',
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
</body>
</html>