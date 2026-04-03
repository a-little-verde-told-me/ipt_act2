@extends('headerfooter')

@section('title', 'Filter & Sort | FLEUR')

@section('content')
<div class="filter-page">
    <h1>Filter & Sort</h1>

    <div class="filter-controls">
        <div class="control-group">
            <label for="filterQuery">Search</label>
            <input id="filterQuery" type="text" placeholder="Type keywords...">
        </div>

        <div class="control-group">
            <label for="filterCategory">Category</label>
            <select id="filterCategory">
                <option value="">All</option>
                <option value="Bouquet">Bouquet</option>
                <option value="Arrangement">Arrangement</option>
                <option value="Gift">Gift</option>
            </select>
        </div>

        <div class="control-group">
            <label for="sortBy">Sort</label>
            <select id="sortBy">
                <option value="name-asc">Name (A-Z)</option>
                <option value="name-desc">Name (Z-A)</option>
                <option value="price-asc">Price (Low-High)</option>
                <option value="price-desc">Price (High-Low)</option>
            </select>
        </div>

        <button class="reset-btn" type="button" id="resetFilter">Reset Filter</button>
    </div>

    <div class="filter-status" id="filterStatus"></div>

    <div class="filter-table">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Keywords</th>
                </tr>
            </thead>
            <tbody id="filterResults"></tbody>
        </table>
    </div>
</div>

<script>
    const data = [
        { name: 'Rustic Wedding Bouquet', category: 'Bouquet', price: 2500, keywords: 'rustic wedding roses greenery' },
        { name: 'Spring Tulip Bundle', category: 'Bouquet', price: 1800, keywords: 'tulip spring pastel' },
        { name: 'Rose Gold Arrangement', category: 'Arrangement', price: 3200, keywords: 'roses elegant centerpiece' },
        { name: 'Sunflower Gift Box', category: 'Gift', price: 1500, keywords: 'sunflower gift box' },
        { name: 'Peony Garden Vase', category: 'Arrangement', price: 2900, keywords: 'peony garden vase' },
        { name: 'Classic Red Roses', category: 'Bouquet', price: 2100, keywords: 'classic red roses romance' },
        { name: 'Lavender Dream', category: 'Bouquet', price: 2000, keywords: 'lavender purple soothing' },
        { name: 'Orchid Luxe', category: 'Arrangement', price: 3500, keywords: 'orchid luxury' },
        { name: 'Carnation Charm', category: 'Bouquet', price: 1700, keywords: 'carnation charm pastel' },
        { name: 'Blooming Surprise', category: 'Gift', price: 1600, keywords: 'gift surprise mixed blooms' },
    ];

    const queryInput = document.getElementById('filterQuery');
    const categorySelect = document.getElementById('filterCategory');
    const sortSelect = document.getElementById('sortBy');
    const resetBtn = document.getElementById('resetFilter');
    const resultsBody = document.getElementById('filterResults');
    const status = document.getElementById('filterStatus');

    function renderRows(items) {
        resultsBody.innerHTML = '';

        if (data.length === 0) {
            status.textContent = 'Data is insufficient.';
            return;
        }

        if (items.length === 0) {
            status.textContent = 'No results found.';
            return;
        }

        status.textContent = `Showing ${items.length} of ${data.length} records.`;

        items.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>${item.category}</td>
                <td>PHP ${item.price}</td>
                <td>${item.keywords}</td>
            `;
            resultsBody.appendChild(row);
        });
    }

    function applyFilters() {
        const q = queryInput.value.trim().toLowerCase();
        const category = categorySelect.value;

        let filtered = data.filter(item => {
            const hay = `${item.name} ${item.keywords}`.toLowerCase();
            const matchesQuery = !q || hay.includes(q);
            const matchesCategory = !category || item.category === category;
            return matchesQuery && matchesCategory;
        });

        const sort = sortSelect.value;
        filtered.sort((a, b) => {
            if (sort === 'name-asc') return a.name.localeCompare(b.name);
            if (sort === 'name-desc') return b.name.localeCompare(a.name);
            if (sort === 'price-asc') return a.price - b.price;
            if (sort === 'price-desc') return b.price - a.price;
            return 0;
        });

        renderRows(filtered);
    }

    queryInput.addEventListener('input', applyFilters);
    categorySelect.addEventListener('change', applyFilters);
    sortSelect.addEventListener('change', applyFilters);

    resetBtn.addEventListener('click', () => {
        queryInput.value = '';
        categorySelect.value = '';
        sortSelect.value = 'name-asc';
        applyFilters();
    });

    applyFilters();
</script>
@endsection
