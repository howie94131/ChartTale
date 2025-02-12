<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ChartTale</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <style>
        html, body {
            height: 100%; /* Full height */
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        main {
            flex: 1; /* Flex-grow to occupy any free space */
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
          <div class="container">
              <a class="navbar-brand <?= service('router')->getMatchedRoute()[0] == 'index' ? 'active' : ''; ?>" href="<?= base_url(); ?>">ChartTale</a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link <?= service('router')->getMatchedRoute()[0] == '/' ? 'active' : ''; ?>" href="<?= base_url(); ?>">Home</a>
                    </li>
                    <?php if (session()->get('isLoggedIn')): ?>
                        <?php if (session()->get('isAdmin')): ?>
                            <li class="nav-item">
                                <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'admin' ? 'active' : ''; ?>" href="<?= base_url("admin"); ?>">Admin Panel</a>
                            </li>
                        <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url("upload"); ?>">Upload</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url("user/charts"); ?>">Chart</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url("logout"); ?>">Logout</a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link <?= service('router')->getMatchedRoute()[0] == 'login' ? 'active' : ''; ?>" href="<?= base_url("login"); ?>">Login</a>
                        </li>
                    <?php endif; ?>
                </ul>
              </div>
          </div>
      </nav>
    </header>

    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <footer class="bg-dark text-light py-4">
        <div class="container">
          <div class="row">
              <div class="col-md-6">
                  <p>&copy; <?= date('Y') ?> ChartTale. All rights reserved.</p>
              </div>
              <div class="col-md-6 text-md-end">
                  <a href="#" class="text-light me-3">Privacy Policy</a>
                  <a href="#" class="text-light">Terms of Service</a>
              </div>
          </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
