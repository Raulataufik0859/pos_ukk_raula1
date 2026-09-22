/**
 * Tampilkan preview foto secara langsung setelah user memilih file,
 * sebelum form disubmit. Dipakai di form Tambah/Edit Produk.
 *
 * @param {string} inputId   id elemen <input type="file">
 * @param {string} previewId id elemen <img> untuk menampilkan preview
 * @param {string} wrapperId id elemen pembungkus preview (disembunyikan kalau belum ada foto)
 */
function setupPhotoPreview(inputId, previewId, wrapperId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const wrapper = document.getElementById(wrapperId);
    if (!input || !preview) return;

    input.addEventListener('change', function () {
        const file = this.files?.[0];
        if (!file) return;

        if (!file.type.startsWith('image/')) {
            alert('Pilih file gambar (jpg, png, webp).');
            this.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function (e) {
            preview.src = e.target.result;
            if (wrapper) wrapper.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    });
}
