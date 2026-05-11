<?php
/** @var array $summary */
/** @var array $stockOverview */
?>
<div class="stats-grid">
    <div class="metric-card">
        <div class="metric-icon"><i class="bi bi-box-seam-fill"></i></div>
        <div><div class="metric-label">Total Barang</div><div class="metric-value"><?= e((string) $summary['total_barang']) ?> <span>barang</span></div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon"><i class="bi bi-person-workspace"></i></div>
        <div><div class="metric-label">Total Pemasok</div><div class="metric-value"><?= e((string) $summary['total_supplier']) ?> <span>pemasok</span></div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon"><i class="bi bi-box-arrow-in-down"></i></div>
        <div><div class="metric-label">Barang Masuk</div><div class="metric-value"><?= e((string) $summary['barang_masuk']) ?> <span>Barang</span></div></div>
    </div>
    <div class="metric-card">
        <div class="metric-icon"><i class="bi bi-box-arrow-up"></i></div>
        <div><div class="metric-label">Barang Keluar</div><div class="metric-value"><?= e((string) $summary['barang_keluar']) ?> <span>Barang</span></div></div>
    </div>
</div>

<section class="panel-card mb-4">
    <h3 class="section-title">Grafik Transaksi</h3>
    <div class="chart-box">
        <canvas id="transactionChart" height="120"></canvas>
    </div>
</section>

<section class="panel-card">
    <h3 class="section-title">Ringkasan Stok</h3>
    <div class="table-shell">
        <table class="table app-table align-middle mb-0">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($stockOverview as $item): ?>
                    <tr>
                        <td><?= e($item['kode_barang']) ?></td>
                        <td><?= e($item['nama_barang']) ?></td>
                        <td><?= e((string) $item['stok']) ?></td>
                        <td>
                            <span class="status-pill <?= (int) $item['stok'] < STOCK_MINIMUM_ALERT ? 'low' : 'safe' ?>">
                                <?= (int) $item['stok'] < STOCK_MINIMUM_ALERT ? 'Menipis' : 'Aman' ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
<script>
const transactionCtx = document.getElementById('transactionChart');
if (transactionCtx) {
    new Chart(transactionCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($summary['chart_labels']) ?>,
            datasets: [
                {
                    label: 'Barang Keluar',
                    data: <?= json_encode($summary['chart_outgoing']) ?>,
                    backgroundColor: '#cc0000'
                },
                {
                    label: 'Barang Masuk',
                    data: <?= json_encode($summary['chart_incoming']) ?>,
                    backgroundColor: '#11d400'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true }
            },
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: { boxWidth: 14 }
                }
            }
        }
    });
}
</script>
