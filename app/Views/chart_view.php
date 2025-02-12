<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
    <section class="py-5">
        <div class="container">
            <canvas id="chartCanvas"></canvas>
        </div>
    </section>
</main>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('chartCanvas').getContext('2d');
        const parsedData = <?= json_encode($parsed_data) ?>;
        const xColumns = <?= json_encode($xColumns) ?>;
        const chartColors = <?= json_encode($chartColors) ?>;
        const chartType = '<?= $chartType ?>';

        let datasets;

        if (chartType === 'mixed') {
            datasets = xColumns.map((col, index) => {
                return {
                    type: index === 0 ? 'bar' : 'line',
                    label: col,
                    data: parsedData.map(row => row[col]),
                    backgroundColor: chartColors[index],
                    borderColor: chartColors[index],
                    borderWidth: 1
                };
            });
        } else {
            datasets = xColumns.map((col, index) => {
                return {
                    label: col,
                    data: parsedData.map(row => row[col]),
                    backgroundColor: chartColors[index],
                    borderColor: chartColors[index],
                    borderWidth: 1
                };
            });
        }

        new Chart(ctx, {
            type: chartType === 'mixed' ? 'bar' : chartType,
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
