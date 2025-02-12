<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
    <section class="py-5">
        <div class="container">
            <h2>Chart View</h2>

            <div class="mb-4">
                <h3>Chart</h3>
                <canvas id="chartCanvas"></canvas>
            </div>

            <div class="mb-4">
                <h3>Story</h3>
                <p><?= esc($story) ?></p>
            </div>

            <div class="mb-4">
                <h3>QR Code</h3>
                <img src="<?= esc($qr_code) ?>" alt="QR Code">
            </div>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartCanvas').getContext('2d');
        const parsedData = <?= json_encode($parsed_data) ?>;
        const xColumns = <?= json_encode($x_columns) ?>;
        const chartColors = <?= json_encode($chart_colors) ?>;
        const chartType = '<?= $chart['chart_type'] ?>';

        const datasets = xColumns.map((col, index) => {
            return {
                label: col,
                data: parsedData.map(row => row[col]),
                backgroundColor: chartColors[index],
                borderColor: chartColors[index],
                borderWidth: 1
            };
        });

        new Chart(ctx, {
            type: chartType,
            data: {
                labels: parsedData.map((_, index) => index + 1),
                datasets: datasets
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>
