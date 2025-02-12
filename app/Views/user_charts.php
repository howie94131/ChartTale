<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Your Charts</h2>
        </div>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Chart ID</th>
                    <th>Chart Type</th>
                    <th>Theme</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($charts as $chart): ?>
                    <tr>
                        <td><?= esc($chart['chart_id']) ?></td>
                        <td><?= esc($chart['chart_type']) ?></td>
                        <td><?= esc($chart['theme']) ?></td>
                        <td><?= esc($chart['created_at']) ?></td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="<?= base_url('user/charts/view/' . $chart['chart_id']) ?>">View</a>
                            <a class="btn btn-sm btn-secondary" href="<?= base_url('user/charts/edit_story/' . $chart['chart_id']) ?>">Edit Story</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</section>

<?= $this->endSection() ?>
