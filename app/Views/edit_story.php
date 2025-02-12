<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Edit Story</h2>
            </div>

            <form method="post" action="<?= base_url('user/charts/save_story') ?>">
                <input type="hidden" name="chart_id" value="<?= $chart['chart_id'] ?>">

                <div class="mb-3">
                    <label for="story">Story</label>
                    <textarea class="form-control" name="story" id="story" rows="5"><?= esc($chart['story']) ?></textarea>
                </div>

                <button type="submit" class="btn btn-primary">Save Story</button>
            </form>
        </div>
    </section>
</main>

<?= $this->endSection() ?>
