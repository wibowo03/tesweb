<?php
// Koneksi ke database
$host = 'localhost';
$dbname = 'data_pt';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}

// Ambil data perguruan tinggi
$query = "SELECT id_pt, nama_pt, akreditasi_angka, lokasi_angka, jenjang_angka, kuota_angka, ipk_angka, prodi_angka FROM data_pt";
$stmt = $pdo->query($query);
$universities = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Siapkan data untuk TOPSIS
$data = [];
$universityNames = [];
foreach ($universities as $univ) {
    $universityNames[] = $univ['nama_pt'];
    $data[] = [
        (float)$univ['akreditasi_angka'],
        (float)$univ['lokasi_angka'],
        (float)$univ['jenjang_angka'],
        (float)$univ['kuota_angka'],
        (float)$univ['ipk_angka'],
        (float)$univ['prodi_angka']
    ];
}

// Bobot kriteria (sesuaikan dengan kebutuhan)
$weights = [0.25, 0.2, 0.15, 0.2, 0.15, 0.05]; // Akreditasi, Lokasi, Jenjang, Kuota, IPK, Prodi

// Tipe kriteria (semua benefit dalam kasus ini)
$criteriaTypes = ['benefit', 'benefit', 'benefit', 'benefit', 'benefit', 'benefit'];

class TOPSISCalculator {
    private $data;
    private $weights;
    private $criteriaTypes;
    
    public function __construct($data, $weights, $criteriaTypes) {
        $this->data = $data;
        $this->weights = $weights;
        $this->criteriaTypes = $criteriaTypes;
    }
    
    public function calculate() {
        $results = [];
        
        // Langkah 1: Normalisasi Matriks Keputusan
        $normalizationResults = $this->normalizeMatrix();
        $results['normalization'] = $normalizationResults;
        
        // Langkah 2: Pembobotan Matriks Ternormalisasi
        $weightedMatrix = $this->calculateWeightedMatrix($normalizationResults['normalized_matrix']);
        $results['weighted_matrix'] = $weightedMatrix;
        
        // Langkah 3: Solusi Ideal Positif dan Negatif
        $idealSolutions = $this->determineIdealSolutions($weightedMatrix);
        $results['ideal_solutions'] = $idealSolutions;
        
        // Langkah 4: Jarak ke Solusi Ideal
        $distances = $this->calculateDistances($weightedMatrix, $idealSolutions);
        $results['distances'] = $distances;
        
        // Langkah 5: Nilai Preferensi (Skor TOPSIS)
        $preferenceValues = $this->calculatePreferenceValues($distances);
        $results['preference_values'] = $preferenceValues;
        
        return $results;
    }
    
    private function normalizeMatrix() {
        $matrix = $this->data;
        $normalizedMatrix = [];
        $squaredSums = array_fill(0, count($matrix[0]), 0);
        
        // Hitung jumlah kuadrat setiap kolom
        foreach ($matrix as $row) {
            foreach ($row as $col => $value) {
                $squaredSums[$col] += pow($value, 2);
            }
        }
        
        // Hitung akar kuadrat dari jumlah kuadrat
        $sqrtSums = array_map('sqrt', $squaredSums);
        
        // Normalisasi matriks
        foreach ($matrix as $row) {
            $normalizedRow = [];
            foreach ($row as $col => $value) {
                $normalizedRow[] = $value / $sqrtSums[$col];
            }
            $normalizedMatrix[] = $normalizedRow;
        }
        
        return [
            'squared_sums' => $squaredSums,
            'sqrt_sums' => $sqrtSums,
            'normalized_matrix' => $normalizedMatrix
        ];
    }
    
    private function calculateWeightedMatrix($normalizedMatrix) {
        $weightedMatrix = [];
        
        foreach ($normalizedMatrix as $row) {
            $weightedRow = [];
            foreach ($row as $col => $value) {
                $weightedRow[] = $value * $this->weights[$col];
            }
            $weightedMatrix[] = $weightedRow;
        }
        
        return $weightedMatrix;
    }
    
    private function determineIdealSolutions($weightedMatrix) {
        $positiveIdeal = [];
        $negativeIdeal = [];
        $cols = count($weightedMatrix[0]);
        
        for ($col = 0; $col < $cols; $col++) {
            $columnValues = array_column($weightedMatrix, $col);
            
            if ($this->criteriaTypes[$col] == 'benefit') {
                $positiveIdeal[$col] = max($columnValues);
                $negativeIdeal[$col] = min($columnValues);
            } else {
                $positiveIdeal[$col] = min($columnValues);
                $negativeIdeal[$col] = max($columnValues);
            }
        }
        
        return [
            'positive' => $positiveIdeal,
            'negative' => $negativeIdeal
        ];
    }
    
    private function calculateDistances($weightedMatrix, $idealSolutions) {
        $distances = [];
        
        foreach ($weightedMatrix as $rowIndex => $row) {
            $positiveDistance = 0;
            $negativeDistance = 0;
            
            foreach ($row as $col => $value) {
                $positiveDistance += pow($value - $idealSolutions['positive'][$col], 2);
                $negativeDistance += pow($value - $idealSolutions['negative'][$col], 2);
            }
            
            $distances[$rowIndex] = [
                'positive' => sqrt($positiveDistance),
                'negative' => sqrt($negativeDistance)
            ];
        }
        
        return $distances;
    }
    
    private function calculatePreferenceValues($distances) {
        $preferenceValues = [];
        
        foreach ($distances as $rowIndex => $distance) {
            $preferenceValues[$rowIndex] = $distance['negative'] / ($distance['positive'] + $distance['negative']);
        }
        
        return $preferenceValues;
    }
}

// Hitung TOPSIS
$topsis = new TOPSISCalculator($data, $weights, $criteriaTypes);
$results = $topsis->calculate();

// Gabungkan hasil dengan nama universitas
$rankings = [];
foreach ($results['preference_values'] as $i => $score) {
    $rankings[] = [
        'id' => $universities[$i]['id_pt'],
        'name' => $universityNames[$i],
        'score' => $score,
        'accreditation' => $universities[$i]['akreditasi_angka'],
        'location' => $universities[$i]['lokasi_angka'],
        'degree' => $universities[$i]['jenjang_angka'],
        'quota' => $universities[$i]['kuota_angka'],
        'gpa' => $universities[$i]['ipk_angka'],
        'program' => $universities[$i]['prodi_angka']
    ];
}

// Urutkan berdasarkan skor tertinggi
usort($rankings, function($a, $b) {
    return $b['score'] <=> $a['score'];
});
?>

<!DOCTYPE html>
<html>
<head>
    <title>SPK Pemilihan Perguruan Tinggi Program Pertukaran Mahasiswa Merdeka</title>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="assets/css/materialize.css"  media="screen,projection"/>
    <link rel="stylesheet" href="assets/css/table.css">
    <link rel="stylesheet" href="assets/css/style.css">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!--Import jQuery before materialize.js-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/materialize.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Data Table -->
    <link rel="stylesheet" type="text/css" href="assets/dataTable/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8" src="assets/dataTable/jquery.dataTables.min.js"></script>

    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #efefef;
        }
        
        .container {
            padding: 20px 0;
        }
        
        .section-card {
            padding: 40px 0px 20px 0px;
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .card-content {
            padding: 24px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        
        th, td {
            border: 1px solid #d0d0d0;
            padding: 12px;
            text-align: center;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        .top-3 {
            background-color: #e6f7ff;
        }
        
        .search-container {
            margin-bottom: 20px;
        }
        
        .search-container input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 300px;
        }
        
        .search-container button {
            padding: 10px 20px;
            background-color: #009688;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        
        .pagination {
            margin-top: 20px;
            text-align: center;
        }
        
        .pagination a {
            display: inline-block;
            padding: 8px 16px;
            margin: 0 4px;
            color: #009688;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        
        .pagination a:hover {
            background-color: #ddd;
        }
        
        .pagination a[style*="font-weight:bold"] {
            background-color: #009688;
            color: white;
            border: 1px solid #009688;
        }
        
        h1, h2 {
            color: #333;
        }
        
        ul {
            padding-left: 20px;
        }
        
        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="navbar-fixed">
        <nav>
            <div class="container">
                <div class="nav-wrapper">
                    <ul class="left" style="margin-left: -52px;">
                        <li><a href="index.php">HOME</a></li>
                        <li><a href="rekomendasi.php">REKOMENDASI</a></li>
                        <li><a class="active" href="daftar_pt.php">DAFTAR PERGURUAN TINGGI</a></li>
                        <li><a href="#about">TENTANG</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
    
    <div class="container">
        <div class="section-card">
            <div class="card">
                <div class="card-content">
                    <center><h4 style="margin-bottom: 20px;">Rekomendasi Perguruan Tinggi dengan Metode TOPSIS</h4></center>
                    
                    <div class="search-container">
                        <form method="GET">
                            <input type="text" name="search" placeholder="Cari perguruan tinggi..." value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                            <button type="submit">Cari</button>
                        </form>
                    </div>
                    
                    <h5>Top Perguruan Tinggi Terbaik</h5>
                    <table class="hover dataTablesCustom">
                        <thead>
                            <tr>
                                <th><center>Peringkat</center></th>
                                <th><center>Nama Perguruan Tinggi</center></th>
                                <th><center>Skor TOPSIS</center></th>
                                <th><center>Akreditasi</center></th>
                                <th><center>Lokasi</center></th>
                                <th><center>Jenjang</center></th>
                                <th><center>Kuota</center></th>
                                <th><center>IPK</center></th>
                                <th><center>Prodi</center></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            // Filter berdasarkan pencarian jika ada
                            $filteredRankings = $rankings;
                            if (isset($_GET['search']) && !empty($_GET['search'])) {
                                $searchTerm = strtolower($_GET['search']);
                                $filteredRankings = array_filter($rankings, function($item) use ($searchTerm) {
                                    return strpos(strtolower($item['name']), $searchTerm) !== false;
                                });
                            }
                            
                            // Pagination
                            $perPage = 25;
                            $total = count($filteredRankings);
                            $pages = ceil($total / $perPage);
                            $page = isset($_GET['page']) ? max(1, min($pages, (int)$_GET['page'])) : 1;
                            $offset = ($page - 1) * $perPage;
                            $currentPageItems = array_slice($filteredRankings, $offset, $perPage);
                            
                            foreach ($currentPageItems as $i => $univ): 
                                $rank = $offset + $i + 1;
                            ?>
                            <tr class="<?= $rank <= 3 ? 'top-3' : '' ?>">
                                <td><center><?= $rank ?></center></td>
                                <td><center><?= htmlspecialchars($univ['name']) ?></center></td>
                                <td><center><?= number_format($univ['score'], 4) ?></center></td>
                                <td><center><?= $univ['accreditation'] ?></center></td>
                                <td><center><?= $univ['location'] ?></center></td>
                                <td><center><?= $univ['degree'] ?></center></td>
                                <td><center><?= $univ['quota'] ?></center></td>
                                <td><center><?= $univ['gpa'] ?></center></td>
                                <td><center><?= $univ['program'] ?></center></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    
                    <?php if ($pages > 1): ?>
                    <div class="pagination">
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <a href="?page=<?= $i ?><?= isset($_GET['search']) ? '&search='.urlencode($_GET['search']) : '' ?>" 
                               <?= $i == $page ? 'style="font-weight:bold;"' : '' ?>>
                                <?= $i ?>
                            </a>
                            <?php if ($i < $pages) echo ' | '; ?>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>
                    
                    <h5>Parameter Kriteria</h5>
                    <p><strong>Bobot Kriteria:</strong></p>
                    <ul>
                        <li>Akreditasi: 25%</li>
                        <li>Lokasi: 20%</li>
                        <li>Jenjang Pendidikan: 15%</li>
                        <li>Kuota: 20%</li>
                        <li>IPK: 15%</li>
                        <li>Program Studi: 5%</li>
                    </ul>
                    
                    <p><strong>Skala Nilai:</strong></p>
                    <ul>
                        <li>Akreditasi: Unggul (5), Baik Sekali (3), Baik/B (1)</li>
                        <li>Lokasi: Sumatera, Jawa, Bali (5), Kalimantan & Sulawesi (3), Maluku/NTT/Papua (1)</li>
                        <li>Jenjang: Diploma & Sarjana (5), Sarjana (3), Diploma (1)</li>
                        <li>Kuota: >225 (5), 130-225 (3), 50-125 (1)</li>
                        <li>IPK: >3.5 (5), 3.11-3.5 (3), 2.75-3.1 (1)</li>
                        <li>Prodi: Tersedia (5), Tidak Tersedia (1)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Start -->
    <div class="footer-copyright" style="padding: 0px 0px; background-color: white">
        <div class="container">
            <p align="center" style="color: #999">&copy; Sistem Pendukung Keputusan Pemilihan Perguruan Tinggi Program PMM. 2025.</p>
        </div>
    </div>
    <!-- Footer End -->
    
    <script type="text/javascript">
        $(document).ready(function(){
            $('.parallax').parallax();
            $('.modal').modal();
            $('.dataTablesCustom').DataTable({
                "paging": false,
                "searching": false
            });
        });
    </script>
</body>
</html>