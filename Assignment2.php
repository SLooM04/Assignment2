<?php
$apiUrl = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";




// Helper function to fetch and process data
function getApiData(string $url): array
{
    try {
        $response = file_get_contents($url);
        if ($response === false) {
            throw new Exception("Failed to fetch data from API.");
        }

        $decodedData = json_decode($response, true);

        return $decodedData['results'] ?? [];
    } catch (Exception $e) {
        return ['error' => $e->getMessage()];
    }
}

// Fetch data
$data = getApiData($apiUrl);
$error = $data['error'] ?? null;
$records = !$error ? $data : [];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB student nationality</title>
    <style>
        





        
    </style>
</head>

<body>
    <header>
        <h1>UOB student nationality</h1>
    </header>
    <div class="container">
        <?php if ($error): ?>
            <p class="error">Error: <?php echo htmlspecialchars($error); ?></p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>Program</th>
                        <th>Nationality</th>
                        <th>College</th>
                        <th>Number of Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td><?= htmlspecialchars($record['year'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($record['semester'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($record['the_programs'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($record['nationality'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($record['colleges'] ?? 'N/A') ?></td>
                            <td><?= htmlspecialchars($record['number_of_students'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <footer>
        <p>&copy; <?= date("Y") ?> Students Data Portal. Data provided by
            <a href="https://data.gov.bh" target="_blank" rel="noopener noreferrer">
                Bahrain Open Data Portal
            </a>.
        </p>
    </footer>

</body>

</html>