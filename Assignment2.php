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
    * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fb;
            color: #333;
            line-height: 1.6;
        }

        header,
        footer {
            background: #4CAF50;
            color: #fff;
            text-align: center;
            padding: 1rem 0;
        }

        header h1,
        footer p {
            margin: 0;
            font-size: 1.5rem;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            background: #fff;
        }

        table thead {
            background-color: #4CAF50;
            color: white;
        }

        table th,
        table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            font-weight: bold;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .error {
            color: #D32F2F;
            background: #FFCDD2;
            padding: 10px;
            border: 1px solid #D32F2F;
            border-radius: 5px;
            margin-top: 20px;
        }

        footer {

            margin-top: 20px;
        }

        footer p,
        footer a {
            font-size: 15px;
        }


        @media (max-width: 768px) {

            table th,
            table td {
                padding: 10px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>UOB student nationality</h1>
    </header>
    <div class="container">
        <?php if ($error): ?>

            <!-- If an error occurs, display the error message -->
            <p class="error">Error: <?php echo htmlspecialchars($error); ?></p>

            <!-- Display the table with records if no error -->
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

                     <!-- Loop through each record and display it in the table -->
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
         <!-- Footer with copyright and data source -->
        <p>&copy; <?= date("Y") ?> Students Data Portal. Data provided by
            <a href="https://data.gov.bh" target="_blank" rel="noopener noreferrer">
                Bahrain Open Data Portal
            </a>.
        </p>
    </footer>

</body>

</html>