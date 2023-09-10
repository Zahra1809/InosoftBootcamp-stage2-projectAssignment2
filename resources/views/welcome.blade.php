<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Beli</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div class="container">
            <h1>Keranjang Beli</h1>

            <!-- Daftar Produk -->
            <div class="product-list">
                <h2>Daftar Produk</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Deskripsi Produk</th>
                            <th>Stok</th>
                            <th>Harga Satuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produk as $item)
                            <tr>
                                <td>{{ $item->nama }}</td>
                                <td>{{ $item->deskripsi }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>{{ $item->harga }}</td>
                                <td><button class="btn btn-primary" @click="masukkanKeKeranjang('{{ $item->nama }}')">Masukkan Keranjang</button></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Keranjang Belanja -->
            <div class="cart">
                <h2>Keranjang Belanja</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nama Produk</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(item, index) in keranjang" :key="index">
                            <td>{{ item.product_name }}</td>
                            <td>{{ item.quantity }}</td>
                            <td>{{ formatCurrency(item.price) }}</td>
                            <td>
                                <button @click="hapusItem(index)" class="btn btn-danger">Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"></td>
                            <td>Total Harga:</td>
                            <td id="total-harga">{{ formatCurrency(totalHarga) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Tombol Bayar -->
            <button class="btn btn-success" @click="bayar">Bayar</button>
        </div>
    </div>

    <script src="{{ asset('js/app.js') }}"></script>
    <script>
        // Inisialisasi Vue.js
        const app = Vue.createApp({
            data() {
                return {
                    keranjang: [], // Data Keranjang Belanja
                    produk: @json($produk) // Menyimpan data produk dari Laravel
                };
            },
            computed: {
                totalHarga() {
                    return this.keranjang.reduce((total, item) => total + item.price * item.quantity, 0);
                },
            },
            methods: {
                formatCurrency(value) {
                    // Fungsi untuk mengubah nilai menjadi format mata uang
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                },
                masukkanKeKeranjang(namaProduk) {
                    // Temukan produk dengan nama yang sesuai dalam data produk
                    const produkDitemukan = this.produk.find(item => item.nama === namaProduk);
    
                    // Cek apakah produk sudah ada di keranjang
                    const itemDiKeranjang = this.keranjang.find(item => item.product_name === namaProduk);
    
                    if (produkDitemukan && produkDitemukan.stok > 0) {
                        if (itemDiKeranjang) {
                            // Jika produk sudah ada di keranjang, tambahkan jumlahnya
                            itemDiKeranjang.quantity++;
                        } else {
                            // Jika produk belum ada di keranjang, tambahkan sebagai item baru
                            this.keranjang.push({
                                product_name: namaProduk,
                                quantity: 1,
                                price: produkDitemukan.harga
                            });
                        }
                        // Kurangi stok produk
                        produkDitemukan.stok--;
                    }
                },
                hapusItem(index) {
                    const item = this.keranjang[index];
                    // Kembalikan stok produk
                    const produkDitemukan = this.produk.find(produk => produk.nama === item.product_name);
                    produkDitemukan.stok += item.quantity;
    
                    // Hapus item dari keranjang
                    this.keranjang.splice(index, 1);
                },
                bayar() {
                    // Logika untuk proses pembayaran
                    // Di sini Anda dapat mengirim data keranjang ke server untuk proses pembayaran lebih lanjut
                    // Setelah pembayaran berhasil, Anda dapat mengosongkan keranjang
                    // Misalnya:
                    // Axios.post('/proses-pembayaran', { keranjang: this.keranjang })
                    //     .then(response => {
                    //         if (response.data.success) {
                    //             this.keranjang = [];
                    //             alert('Pembayaran berhasil');
                    //         } else {
                    //             alert('Pembayaran gagal');
                    //         }
                    //     })
                    //     .catch(error => {
                    //         console.error(error);
                    //         alert('Terjadi kesalahan saat melakukan pembayaran');
                    //     });
                },
            },
        });
    
        app.mount('#app');
    </script>    
</body>
</html>
