/**
 * Format input harga menjadi Rupiah secara realtime saat diketik.
 * Dipakai di form Tambah/Edit Produk (harga_beli & harga_jual).
 *
 * Pola: input yang terlihat (text, sudah diformat "1.000.000")
 *       + input tersembunyi (hidden, angka murni "1000000") yang
 *       benar-benar dikirim ke server.
 */
function formatRupiahInput(displayId, hiddenId) {
    const display = document.getElementById(displayId);
    const hidden = document.getElementById(hiddenId);
    if (!display || !hidden) return;

    display.addEventListener('input', function () {
        const raw = this.value.replace(/\D/g, ''); // buang semua selain angka
        hidden.value = raw;
        this.value = raw ? new Intl.NumberFormat('id-ID').format(raw) : '';
    });
}
