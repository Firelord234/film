<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Data array asosiatif statis
$data = [
    [
        "id" => 1,
        "judul" => "Inception",
        "genre" => "Sci-Fi",
        "popularitas" => 90,
        "rating" => 4.8,
        "tahun_rilis" => 2010,
        "pemeran_utama" => "Leonardo DiCaprio"
    ],
    [
        "id" => 2,
        "judul" => "The Godfather",
        "genre" => "Drama",
        "popularitas" => 95,
        "rating" => 4.9,
        "tahun_rilis" => 1972,
        "pemeran_utama" => "Marlon Brando"
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

// Fungsi Quick Sort
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

// Filter berdasarkan genre
function filterByGenre($data, $genre) {
    if (empty($genre)) {
        return $data; // Jika tidak ada genre dipilih, kembalikan semua data
    }
    return array_filter($data, function ($item) use ($genre) {
        return $item['genre'] === $genre;
    });
}

// Cek dan pilih metode pengurutan berdasarkan input
if (isset($_GET['sort'])) {
    $sortKey = $_GET['sort'];
    $validSortKeys = ['rating', 'popularitas', 'tahun_rilis'];

    if (in_array($sortKey, $validSortKeys)) {
        $data = quickSort($data, $sortKey);
    } else {
        echo "Kriteria pengurutan tidak valid.";
    }
}

// Filter berdasarkan genre jika ada
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
        /* Tambahkan styling di sini */
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
            <!-- Tambahkan genre lainnya sesuai kebutuhan -->
        </select>
        <input type="submit" value="Tampilkan">
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
    <table border="1">
        <tr>
            <th>Judul</th>
            <th>Genre</th>
            <th>Popularitas</th>
            <th>Rating</th>
            <th>Tahun Rilis</th>
            <th>Pemeran Utama</th>
        </tr>

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
