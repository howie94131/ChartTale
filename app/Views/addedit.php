<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h2 class="text-center mb-4"><?= isset($user) ? 'Edit User' : 'Add User' ?></h2>
                <form method="post" action="<?= base_url('admin/addedit' . (isset($user) ? '/' . $user['user_id'] : '')) ?>">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= isset($user) ? esc($user['username']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?= isset($user) ? esc($user['email']) : '' ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="Active" <?= isset($user) && $user['status'] === 'Active' ? 'selected' : '' ?>>Active</option>
                            <option value="Inactive" <?= isset($user) && $user['status'] === 'Inactive' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><?= isset($user) ? 'Update User' : 'Add User' ?></button>
                </form>
            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>