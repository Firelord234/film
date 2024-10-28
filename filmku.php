<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = [
    [
        "id" => 1,
        "judul" => "Nando Suka Mancing",
        "genre" => "Sci-Fi",
        "popularitas" => 90,
        "rating" => 5.0,
        "tahun_rilis" => 2024,
        "pemeran_utama" => "Fernando Nopensa"
    ],
    [
        "id" => 2,
        "judul" => "Aldo Wong Ngapak",
        "genre" => "Drama",
        "popularitas" => 95,
        "rating" => 4.9,
        "tahun_rilis" => 2019,
        "pemeran_utama" => "M. Aldo"
    ],
    [
        "id" => 3,
        "judul" => "Interstellar",
        "genre" => "Sci-Fi",
        "popularitas" => 85,
        "rating" => 4.7,
        "tahun_rilis" => 2014,
        "pemeran_utama" => "Matthew McConaughey"
    ],
    [
        "id" => 4,
        "judul" => "Avengers: Endgame",
        "genre" => "Action",
        "popularitas" => 92,
        "rating" => 4.6,
        "tahun_rilis" => 2019,
        "pemeran_utama" => "Robert Downey Jr."
    ],
    [
        "id" => 5,
        "judul" => "Toy Story 3",
        "genre" => "Animation",
        "popularitas" => 80,
        "rating" => 4.5,
        "tahun_rilis" => 2010,
        "pemeran_utama" => "Tom Hanks"
    ]
];

function quickSort($data, $key) {
    if (count($data) < 2) {
        return $data;
    }

    $left = $right = [];
    $pivot = $data[0];

    for ($i = 1; $i < count($data); $i++) {
        if ($data[$i][$key] > $pivot[$key]) {
            $left[] = $data[$i];
        } else {
            $right[] = $data[$i];
        }
    }

    return array_merge(quickSort($left, $key), [$pivot], quickSort($right, $key));
}

function filterByGenre($data, $genre) {
    if (empty($genre)) {
        return $data;
    }
    return array_filter($data, function ($item) use ($genre) {
        return $item['genre'] === $genre;
    });
}

if (isset($_GET['sort'])) {
    $sortKey = $_GET['sort'];
    $validSortKeys = ['rating', 'popularitas', 'tahun_rilis'];

    if (in_array($sortKey, $validSortKeys)) {
        $data = quickSort($data, $sortKey);
    } else {
        echo "Kriteria pengurutan tidak valid.";
    }
}

$selectedGenre = isset($_GET['genre']) ? $_GET['genre'] : '';
$filteredData = filterByGenre($data, $selectedGenre);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Film</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f5;
            color: #333;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #555;
        }
        form {
            margin-bottom: 20px;
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        select, button {
            padding: 8px 12px;
            margin: 0 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #ddd;
        }
        p {
            text-align: center;
            font-size: 1.1em;
            color: #333;
        }
    </style>
</head>
<body>
    <form method="GET" action="">
        <label for="genre">Pilih Genre:</label>
        <select name="genre" id="genre">
            <option value="">Semua Genre</option>
            <option value="Action">Action</option>
            <option value="Drama">Drama</option>
            <option value="Sci-Fi">Sci-Fi</option>
            <option value="Animation">Animation</option>
        </select>
        <button type="submit">Tampilkan</button>
    </form>

    <form method="get" action="">
        <label for="sort">Urutkan Berdasarkan:</label>
        <select name="sort" id="sort">
            <option value="rating">Rating</option>
            <option value="popularitas">Popularitas</option>
            <option value="tahun_rilis">Tahun Rilis</option>
        </select>
        <button type="submit">Urutkan</button>
    </form>

    <h2>Daftar Film</h2>
    <table>
        <thead>
            <tr>
                <th>Judul</th>
                <th>Genre</th>
                <th>Popularitas</th>
                <th>Rating</th>
                <th>Tahun Rilis</th>
                <th>Pemeran Utama</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($filteredData)): ?>
                <?php foreach ($filteredData as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['judul']); ?></td>
                        <td><?php echo htmlspecialchars($item['genre']); ?></td>
                        <td><?php echo htmlspecialchars($item['popularitas']); ?></td>
                        <td><?php echo htmlspecialchars($item['rating']); ?></td>
                        <td><?php echo htmlspecialchars($item['tahun_rilis']); ?></td>
                        <td><?php echo htmlspecialchars($item['pemeran_utama']); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">Tidak ada data untuk ditampilkan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <p>Menampilkan hasil untuk genre: <strong><?php echo !empty($selectedGenre) ? htmlspecialchars($selectedGenre) : 'Semua Genre'; ?></strong></p>
</body>
</html>
