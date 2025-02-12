<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\Database\Exceptions\DatabaseException;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;

class FileUploadController extends Controller
{
    protected $session;

    public function __construct()
    {
        helper(['url', 'form', 'custom']);
        $this->session = session();
    }

    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $model = new \App\Models\UploadModel();
        $user_id = session()->get('user_id');
        $data['uploads'] = $model->where('user_id', $user_id)->findAll();

        return view('upload', $data);
    }

    public function upload()
    {
        helper(['form', 'url']);

        // Ensure session is started
        if (!session()->get('isLoggedIn')) {
            return $this->response->setJSON(['message' => 'User is not logged in or session has expired', 'success' => false], 403);
        }

        $user_id = (int)session()->get('user_id');
        log_message('debug', 'Session Data before upload: ' . json_encode(session()->get()));
        log_message('debug', 'Retrieved user_id: ' . $user_id);

        $file = $this->request->getFile('file');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH . 'uploads', $newName);

            // Parse CSV and convert to JSON
            $filePath = WRITEPATH . 'uploads/' . $newName;
            $parsedData = $this->parseCSV($filePath);

            if ($parsedData) {
                $uploadModel = new \App\Models\UploadModel();
                $data = [
                    'user_id' => $user_id,
                    'filename' => $newName,
                    'created_at' => date('Y-m-d H:i:s'),
                    'size' => $file->getSize(),
                    'parsed_data' => json_encode($parsedData)
                ];
                log_message('debug', 'Data to be inserted: ' . json_encode($data));

                if ($uploadModel->insert($data)) {
                    return $this->response->setJSON(['message' => 'File uploaded and parsed successfully', 'success' => true]);
                } else {
                    return $this->response->setJSON(['message' => 'Failed to insert data into database', 'success' => false]);
                }
            } else {
                return $this->response->setJSON(['message' => 'File uploaded but parsing failed', 'success' => false]);
            }
        } else {
            return $this->response->setJSON(['message' => 'File upload failed', 'error' => $file->getErrorString(), 'success' => false]);
        }
    }

    public function delete($id)
    {
        $model = new \App\Models\UploadModel();
        $user_id = session()->get('user_id');

        $upload = $model->find($id);

        if ($upload && $upload['user_id'] == $user_id) {
            if ($model->delete($id)) {
                $this->session->setFlashdata('success', 'Data entry deleted successfully.');
            } else {
                $this->session->setFlashdata('error', 'Failed to delete data entry. Please try again.');
            }
        } else {
            $this->session->setFlashdata('error', 'Unauthorized action.');
        }

        return redirect()->to('/upload');
    }

    public function view($id)
    {
        $chartModel = new \App\Models\ChartModel();
        $uploadModel = new \App\Models\UploadModel();
        $user_id = session()->get('user_id');

        $chart = $chartModel->find($id);

        if ($chart) {
            $upload = $uploadModel->find($chart['data_id']);
            if ($upload && $upload['user_id'] == $user_id) {
                $data = [
                    'chart' => $chart,
                    'parsed_data' => json_decode($upload['parsed_data'], true),
                    'story' => $chart['story'],
                    'qr_code' => $this->generateQRCode(base_url('view_chart/' . $id))
                ];
                return view('view_chart', $data);
            }
        }

        return redirect()->to('/user/charts')->with('error', 'Unauthorized access or chart not found');
    }



    public function chart($id)
    {
        $model = new \App\Models\UploadModel();
        $user_id = session()->get('user_id');

        $upload = $model->find($id);

        if ($upload && $upload['user_id'] == $user_id) {
            $data = [
                'upload' => $upload,
                'columns' => array_keys(json_decode($upload['parsed_data'], true)[0])
            ];
            return view('chart_selection', $data);
        } else {
            return $this->response->setJSON(['message' => 'Unauthorized access or data not found', 'success' => false], 403);
        }
    }

    public function generateChart()
    {
        $xColumns = $this->request->getPost('xColumns');
        $chartType = $this->request->getPost('chartType');
        $uploadId = $this->request->getPost('uploadId');
        $theme = $this->request->getPost('theme');
        $save = $this->request->getPost('save');

        $themes = [
            'theme1' => ['#FF6384', '#36A2EB', '#FFCE56'],
            'theme2' => ['#4BC0C0', '#FF9F40', '#FF6384'],
            'theme3' => ['#9966FF', '#4BC0C0', '#FFCE56'],
        ];
        
        $chartColors = $themes[$theme];

        $chartModel = new \App\Models\ChartModel();
        $data = [
            'data_id' => $uploadId,
            'chart_type' => $chartType,
            'theme' => $theme,
            'columns' => json_encode($xColumns),
            'created_at' => date('Y-m-d H:i:s')
        ];
        $chartModel->insert($data);

        $model = new \App\Models\UploadModel();
        $upload = $model->find($uploadId);

        if ($upload && $upload['user_id'] == session()->get('user_id')) {
            $data = [
                'chartType' => $chartType,
                'xColumns' => $xColumns,
                'chartColors' => $chartColors,
                'parsed_data' => json_decode($upload['parsed_data'], true)
            ];
            return view('chart_view', $data);
        } else {
            return $this->response->setJSON(['message' => 'Unauthorized access or data not found', 'success' => false], 403);
        }
    }

    public function userCharts()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $user_id = session()->get('user_id');

        $chartModel = new \App\Models\ChartModel();
        $uploadModel = new \App\Models\UploadModel();

        $charts = $chartModel->join('UploadedData', 'Chart.data_id = UploadedData.data_id')
                            ->where('UploadedData.user_id', $user_id)
                            ->findAll();

        $data['charts'] = $charts;

        return view('user_charts', $data);
    }

    public function deleteChart($id)
    {
        $chartModel = new \App\Models\ChartModel();
        $uploadModel = new \App\Models\UploadModel();

        $chart = $chartModel->find($id);

        if ($chart) {
            $upload = $uploadModel->find($chart['data_id']);
            if ($upload && $upload['user_id'] == session()->get('user_id')) {
                $chartModel->delete($id);
                $this->session->setFlashdata('success', 'Chart deleted successfully.');
            } else {
                $this->session->setFlashdata('error', 'Unauthorized action.');
            }
        } else {
            $this->session->setFlashdata('error', 'Chart not found.');
        }

        return redirect()->to('/user/charts');
    }

    public function viewChart($id)
    {
        $chartModel = new \App\Models\ChartModel();
        $uploadModel = new \App\Models\UploadModel();
        $user_id = session()->get('user_id');

        $chart = $chartModel->find($id);

        if ($chart) {
            $upload = $uploadModel->find($chart['data_id']);
            if ($upload && $upload['user_id'] == $user_id) {
                $xColumns = json_decode($chart['columns'], true);
                $chartColors = $this->getChartColors($chart['theme']);

                $data = [
                    'chart' => $chart,
                    'parsed_data' => json_decode($upload['parsed_data'], true),
                    'story' => isset($chart['story']) ? $chart['story'] : '',
                    'qr_code' => $this->generateQRCode(base_url('view_chart/' . $id)),
                    'x_columns' => $xColumns,
                    'chart_colors' => $chartColors
                ];
                return view('view_chart', $data);
            }
        }

        return redirect()->to('/user/charts')->with('error', 'Unauthorized access or chart not found');
    }

    private function getChartColors($theme)
    {
        $themes = [
            'theme1' => ['#FF6384', '#36A2EB', '#FFCE56'],
            'theme2' => ['#4BC0C0', '#FF9F40', '#FF6384'],
            'theme3' => ['#9966FF', '#4BC0C0', '#FFCE56'],
        ];

        return $themes[$theme] ?? $themes['theme1'];
    }



    public function editStory($chart_id)
    {
        $model = new \App\Models\ChartModel();
        $user_id = session()->get('user_id');

        $chart = $model->find($chart_id);

        if ($chart && $chart['data_id'] && $this->isUserChart($chart['data_id'], $user_id)) {
            return view('edit_story', ['chart' => $chart]);
        } else {
            return redirect()->to('/user/charts')->with('error', 'Unauthorized access or chart not found');
        }
    }

    public function saveStory()
    {
        $chart_id = $this->request->getPost('chart_id');
        $story = $this->request->getPost('story');

        $model = new \App\Models\ChartModel();
        $user_id = session()->get('user_id');

        $chart = $model->find($chart_id);

        if ($chart && $chart['data_id'] && $this->isUserChart($chart['data_id'], $user_id)) {
            $data = [
                'story' => $story,
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            if (!empty($data['story'])) { // Ensure story is not empty
                if ($model->update($chart_id, $data)) {
                    return redirect()->to('/user/charts')->with('success', 'Story saved successfully');
                } else {
                    return redirect()->to('/user/charts')->with('error', 'Failed to save story');
                }
            } else {
                return redirect()->to('/user/charts')->with('error', 'No data to update');
            }
        } else {
            return redirect()->to('/user/charts')->with('error', 'Unauthorized access or chart not found');
        }
    }


    private function isUserChart($data_id, $user_id)
    {
        $uploadModel = new \App\Models\UploadModel();
        $upload = $uploadModel->find($data_id);

        return $upload && $upload['user_id'] == $user_id;
    }


    private function parseCSV($filePath)
    {
        try {
            $csvFile = fopen($filePath, 'r');
            $header = fgetcsv($csvFile);

            $parsedData = [];
            while (($row = fgetcsv($csvFile)) !== FALSE) {
                $rowData = array_combine($header, $row);
                $parsedData[] = $rowData;
            }
            fclose($csvFile);

            return $parsedData;
        } catch (\Exception $e) {
            log_message('error', 'Error parsing CSV: ' . $e->getMessage());
            return false;
        }
    }

    private function generateQRCode($url)
    {
        $qrCode = new QrCode($url);
        $writer = new PngWriter();

        $result = $writer->write($qrCode);

        return $result->getDataUri();
    }

}
