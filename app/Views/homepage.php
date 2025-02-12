<?= $this->extend('template') ?>
<?= $this->section('content') ?>
    
<main>
      <section class="py-5 bg-light">
          <div class="container ">
              <div class="row">
                  <div class="text-center py-5">
                      <h1 class="display-4 ">Welcome to ChartTale</h1>
                      <p class="lead">ChartTale simplifies data visualization for you. Sign up and upload your csv file to start:</p>
                      <br>
                      <div class="text-center">
                        <?php if (session()->get('isLoggedIn')): ?>
                            <a class="btn btn-primary btn-lg mb-1 mb-lg-0 " href="<?= base_url('upload');?>">Get Started</a>
                        <?php else: ?>
                            <a class="btn btn-primary btn-lg mb-1 mb-lg-0 <?= service('router')->getMatchedRoute()[0] == 'login' ? 'active' : ''; ?>" href="<?= base_url("login"); ?>">Get Started</a>
                        <?php endif; ?>
                      </div>
                  </div>
              </div>
          </div>
      </section>

      <section class="py-5">
          <div class="container">
              <h2 class="text-center mb-4">Key Features</h2>
              <br>
              <div class="row">
                  <div class="col-lg-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Data Upload</h4>
                              <p class="card-text">Upload your local data in csv format to create nice visualization.</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Chart Visualization</h4>
                              <p class="card-text">Select from the variety of charts that best suited your need for visual story.</p>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-4 mb-4">
                      <div class="card">
                          <div class="card-body">
                              <h4 class="card-title">Stories and Sharing</h4>
                              <p class="card-text">Create stories behind the chart and share it with everyone using the QR code.</p>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </section>
  </main>

<?= $this->endSection() ?>
