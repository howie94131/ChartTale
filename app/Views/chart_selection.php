<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Select Columns for Chart</h2>
            </div>

            <form method="post" action="<?= base_url('upload/generate_chart') ?>">
                <input type="hidden" name="uploadId" value="<?= $upload['data_id'] ?>">
                
                <div class="mb-3">
                    <label for="chartType">Select Chart Type</label>
                    <select class="form-control" name="chartType" id="chartType">
                        <option value="bar">Bar Chart</option>
                        <option value="line">Line Chart</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="theme">Select Theme</label>
                    <select class="form-control" name="theme" id="theme">
                        <option value="theme1">Theme 1</option>
                        <option value="theme2">Theme 2</option>
                        <option value="theme3">Theme 3</option>
                    </select>
                </div>

                <div id="columns-container">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="xColumns">Select Columns</label>
                            <select class="form-control" name="xColumns[]">
                                <?php foreach ($columns as $column): ?>
                                    <option value="<?= $column ?>"><?= $column ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col">
                            <label>Actions</label>
                            <div>
                                <button type="button" class="btn btn-danger remove-column">Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                <button type="button" class="btn btn-secondary add-column">Add Column</button>
                <button type="submit" class="btn btn-primary">Generate Chart</button>
            </form>
        </div>
    </section>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('.add-column').addEventListener('click', function () {
            const container = document.getElementById('columns-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3';
            newRow.innerHTML = `
                <div class="col">
                    <label for="xColumns">Select Columns</label>
                    <select class="form-control" name="xColumns[]">
                        <?php foreach ($columns as $column): ?>
                            <option value="<?= $column ?>"><?= $column ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col">
                    <label>Actions</label>
                    <div>
                        <button type="button" class="btn btn-danger remove-column">Remove</button>
                    </div>
                </div>
            `;
            container.appendChild(newRow);

            newRow.querySelector('.add-column').addEventListener('click', function () {
                container.appendChild(newRow.cloneNode(true));
            });

            newRow.querySelector('.remove-column').addEventListener('click', function () {
                newRow.remove();
            });
        });

        document.querySelectorAll('.remove-column').forEach(button => {
            button.addEventListener('click', function () {
                button.closest('.row').remove();
            });
        });
    });
</script>

<?= $this->endSection() ?>
