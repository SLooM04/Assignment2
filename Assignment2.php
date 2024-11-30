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