<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container text-center">
        <div class="text-center py-5">
            <h1 class="display-4">Access Denied</h1>
            <p class="lead">You do not have permission to access this page.</p>
            <br>
            <div class="text-center">
                <a href="<?= base_url(); ?>" class="btn btn-primary">Go to Home</a>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>