<template>
    <div>
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
            <td>{{ formatCurrency(totalHarga) }}</td>
          </tr>
        </tfoot>
      </table>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        keranjang: [], // Data Keranjang Belanja
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
      hapusItem(index) {
        // Fungsi untuk menghapus item dari keranjang belanja
        this.keranjang.splice(index, 1);
      },
    },
  };
  </script>
  
  <style scoped>
  /* CSS styling khusus untuk komponen ini, jika diperlukan */
  </style>
  