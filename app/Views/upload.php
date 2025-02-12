<?= $this->extend('template') ?>
<?= $this->section('content') ?>

<main>
    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>File Upload</h2>
            </div>
            <form action="<?= base_url('upload'); ?>" class="dropzone" id="myDropzone">
                <?= csrf_field() ?>
            </form>

            <div id="message" class="message"></div>
                
            <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/min/dropzone.min.js"></script>
            <script>
                Dropzone.options.myDropzone = {
                    paramName: "file", // The name that will be used to transfer the file
                    maxFilesize: 20, // MB
                    acceptedFiles: ".csv",
                    init: function() {
                        this.on("success", function(file, response) {
                            showMessage(response.message, response.success ? "success" : "error");
                            if (response.success) {
                                parseCSV(response.filePath);
                            }
                        });
                        this.on("error", function(file, errorMessage, xhr) {
                            if (xhr) {
                                let response = JSON.parse(xhr.responseText);
                                showMessage("File upload error: " + response.message + (response.error ? " (" + response.error + ")" : ""), "error");
                            } else {
                                showMessage("File upload error: " + errorMessage, "error");
                            }
                        });
                    }
                };

                function showMessage(message, type) {
                    var messageElement = document.getElementById("message");
                    messageElement.textContent = message;
                    messageElement.className = "message " + type;
                }

                function parseCSV(filePath) {
                    Papa.parse(filePath, {
                        download: true,
                        complete: function(results) {
                            console.log(results.data);
                            generateChart(results.data);
                        }
                    });
                }

                function generateChart(data) {
                    const ctx = document.getElementById('chart').getContext('2d');
                    const labels = data.map(row => row[Object.keys(row)[0]]);
                    const values = data.map(row => row[Object.keys(row)[1]]);

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'CSV Data',
                                data: values,
                                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                                borderColor: 'rgba(75, 192, 192, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                }
            </script>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Uploaded Data</h2>
            </div>

            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Data ID</th>
                        <th>Filename</th>
                        <th>Uploaded At</th>
                        <th>Size (KB)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($uploads as $upload): ?>
                    <tr>
                        <td><?= esc($upload['data_id']) ?></td>
                        <td><?= esc($upload['filename']) ?></td>
                        <td><?= esc($upload['created_at']) ?></td>
                        <td><?= esc($upload['size']) ?></td>
                        <td>
                            <a class="btn btn-sm btn-info" href="#" onclick="viewJson(<?= $upload['data_id'] ?>)">
                                <i class="bi bi-eye-fill"></i> 
                            </a>
                            <a class="btn btn-sm btn-danger" href="<?= base_url('upload/delete/' . $upload['data_id']) ?>" onclick="return confirm('Are you sure you want to delete this data entry?')">
                                <i class="bi bi-trash-fill"></i> 
                            </a>
                            <a class="btn btn-sm btn-primary" href="<?= base_url('upload/chart/' . $upload['data_id']) ?>">
                                <i class="bi bi-bar-chart-fill"></i> Generate Chart
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Modal for displaying JSON content -->
            <div class="modal fade" id="jsonModal" tabindex="-1" aria-labelledby="jsonModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="jsonModalLabel">JSON Content</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="jsonContent"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function viewJson(dataId) {
                    fetch(`<?= base_url('upload/view/') ?>${dataId}`)
                        .then(response => response.json())
                        .then(data => {
                            const jsonContent = JSON.stringify(data.parsed_data, null, 2);
                            document.getElementById('jsonContent').textContent = jsonContent;
                            const jsonModal = new bootstrap.Modal(document.getElementById('jsonModal'));
                            jsonModal.show();
                        })
                        .catch(error => {
                            console.error('Error fetching JSON data:', error);
                            alert('Failed to fetch JSON data.');
                        });
                }
            </script>
        </div>
    </section>
</main>

<?= $this->endSection() ?>
