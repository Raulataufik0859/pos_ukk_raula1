/**
 * Kalkulasi otomatis di form Tambah/Edit Produk:
 *   1. Harga Jual   = Harga Beli + (Harga Beli x Persen Laba / 100)
 *   2. Batas Diskon = minimal 1/3 dari persen laba, maksimal 2/3 dari persen laba
 *      contoh: laba 30% -> diskon hanya boleh 10% s.d. 20%
 *
 * Semua elemen diakses lewat id, dipanggil sekali saat halaman dimuat.
 */
function setupHitungHargaProduk() {
    const hargaBeliHidden   = document.getElementById('harga_beli');
    const persenLabaInput   = document.getElementById('persen_laba');
    const hargaJualDisplay  = document.getElementById('harga_jual_display');
    const persenDiskonInput = document.getElementById('persen_diskon');
    const batasDiskonInfo   = document.getElementById('batas_diskon_info');
    const hargaFinalDisplay = document.getElementById('harga_final_display');

    if (!hargaBeliHidden || !persenLabaInput) return;

    function formatRupiah(angka) {
        return 'Rp ' + new Intl.NumberFormat('id-ID').format(Math.round(angka) || 0);
    }

    function hitungUlang() {
        const hargaBeli = parseInt(hargaBeliHidden.value || '0', 10);
        const persenLaba = parseInt(persenLabaInput.value || '0', 10);
        const persenDiskon = parseInt(persenDiskonInput?.value || '0', 10);

        // 1) Harga jual otomatis dari harga beli + persen laba
        const hargaJual = hargaBeli + (hargaBeli * persenLaba / 100);
        if (hargaJualDisplay) hargaJualDisplay.textContent = formatRupiah(hargaJual);

        // 2) Batas diskon yang diperbolehkan
        const batasMin = Math.round(persenLaba / 3);
        const batasMax = Math.round(persenLaba * 2 / 3);
        if (batasDiskonInfo) {
            batasDiskonInfo.textContent = persenLaba > 0
                ? `Diskon boleh diisi 0%, atau antara ${batasMin}% - ${batasMax}% (dari laba ${persenLaba}%).`
                : 'Isi persen laba dahulu untuk melihat batas diskon.';
        }

        // 3) Harga final setelah diskon
        if (hargaFinalDisplay) {
            const hargaFinal = persenDiskon > 0
                ? hargaJual - (hargaJual * persenDiskon / 100)
                : hargaJual;
            hargaFinalDisplay.textContent = formatRupiah(hargaFinal);
        }
    }

    persenLabaInput.addEventListener('input', hitungUlang);
    persenDiskonInput?.addEventListener('input', hitungUlang);
    hargaBeliHidden.addEventListener('input', hitungUlang);
    // hidden input di-update oleh rupiah-input.js saat mengetik harga beli,
    // pakai event 'change' tambahan supaya tetap sinkron.
    document.getElementById('harga_beli_display')?.addEventListener('input', hitungUlang);

    hitungUlang();
}
