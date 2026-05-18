<?php
/** @var array $products */
/** @var bool|null $showStock */

$showStock = $showStock ?? false;
$productSearchItems = array_map(static function (array $product) use ($showStock): array {
    $meta = [
        $product['kategori'] ?? '',
        $product['nama_supplier'] ?? '',
    ];

    if ($showStock) {
        $meta[] = 'Stok: ' . ($product['stok'] ?? 0);
    }

    return [
        'id' => (int) $product['id_barang'],
        'code' => (string) $product['kode_barang'],
        'name' => (string) $product['nama_barang'],
        'meta' => implode(' - ', array_filter($meta)),
        'search' => strtolower(implode(' ', [
            $product['kode_barang'] ?? '',
            $product['nama_barang'] ?? '',
            $product['kategori'] ?? '',
            $product['nama_supplier'] ?? '',
        ])),
    ];
}, $products);
?>
<div class="modal-field full product-search-field" data-product-search>
    <label>Barang</label>
    <input type="hidden" name="id_barang" data-product-id>
    <div class="product-search-box">
        <i class="bi bi-search"></i>
        <input
            type="search"
            class="app-input product-search-input"
            placeholder="Cari kode, nama, kategori, atau supplier barang..."
            autocomplete="off"
            data-product-query
            required
        >
    </div>
    <div class="product-search-selected" data-product-selected hidden></div>
    <div class="product-search-results" data-product-results hidden></div>
    <div class="product-search-empty" data-product-empty hidden>Barang tidak ditemukan.</div>
</div>

<script>
(() => {
    const form = document.currentScript.closest('form');
    const root = form ? form.querySelector('[data-product-search]') : null;
    if (!root) {
        return;
    }

    const products = <?= json_encode($productSearchItems, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) ?>;
    const queryInput = root.querySelector('[data-product-query]');
    const idInput = root.querySelector('[data-product-id]');
    const results = root.querySelector('[data-product-results]');
    const selected = root.querySelector('[data-product-selected]');
    const empty = root.querySelector('[data-product-empty]');

    const clearSelection = () => {
        idInput.value = '';
        selected.hidden = true;
        selected.textContent = '';
    };

    const hideResults = () => {
        results.hidden = true;
        empty.hidden = true;
    };

    const chooseProduct = (product) => {
        idInput.value = product.id;
        queryInput.value = product.code + ' - ' + product.name;
        selected.textContent = product.meta ? product.meta : 'Barang dipilih';
        selected.hidden = false;
        hideResults();
    };

    const renderResults = () => {
        const keyword = queryInput.value.trim().toLowerCase();
        clearSelection();

        if (keyword.length < 2) {
            hideResults();
            return;
        }

        const matches = products
            .filter((product) => product.search.includes(keyword))
            .slice(0, 8);

        results.innerHTML = '';

        if (matches.length === 0) {
            results.hidden = true;
            empty.hidden = false;
            return;
        }

        matches.forEach((product) => {
            const button = document.createElement('button');
            button.type = 'button';
            button.className = 'product-search-option';
            button.innerHTML = `
                <span>
                    <strong>${escapeHtml(product.code)} - ${escapeHtml(product.name)}</strong>
                    ${product.meta ? `<small>${escapeHtml(product.meta)}</small>` : ''}
                </span>
                <i class="bi bi-check2-circle"></i>
            `;
            button.addEventListener('click', () => chooseProduct(product));
            results.appendChild(button);
        });

        empty.hidden = true;
        results.hidden = false;
    };

    const escapeHtml = (value) => String(value).replace(/[&<>"']/g, (character) => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    }[character]));

    queryInput.addEventListener('input', renderResults);
    queryInput.addEventListener('focus', renderResults);
    queryInput.addEventListener('keydown', (event) => {
        if (event.key !== 'Enter' || results.hidden) {
            return;
        }

        const firstOption = results.querySelector('.product-search-option');
        if (firstOption) {
            event.preventDefault();
            firstOption.click();
        }
    });

    document.addEventListener('click', (event) => {
        if (!root.contains(event.target)) {
            hideResults();
        }
    });

    form.addEventListener('submit', (event) => {
        if (idInput.value) {
            return;
        }

        event.preventDefault();
        queryInput.setCustomValidity('Pilih barang dari hasil pencarian.');
        queryInput.reportValidity();
        queryInput.setCustomValidity('');
    });
})();
</script>
