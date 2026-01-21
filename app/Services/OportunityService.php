<?php
declare(strict_types=1);

final class GeminiPlanGenerator
{
    private string $apiKey;
    private string $endpoint;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;

        // Use the correct v1beta model
        $this->endpoint =
            'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent'
            . '?key=' . $this->apiKey;
    }

    /**
     * Main entry point to generate daily opportunities
     */
    public function generateDailyOpportunities(array $userInterests): void
    {
        $prompt = $this->buildPrompt($userInterests);
        $response = $this->callGemini($prompt);
        $this->outputHtml($response);
    }

    /**
     * Build the Gemini prompt based on user interests
     */
    private function buildPrompt(array $userInterests): string
    {
        $interestsJson = json_encode($userInterests, JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
Generate a list of daily opportunities for the user based on these interests:
$interestsJson

Requirements:
- Maximum 5 opportunities every 24hours (5 each day)
- Each opportunity must have:
  - A title
  - A short description (1-2 sentences)
  - A representative image URL
- Return ONLY raw HTML
- Use HTML, Tailwind CSS (via CDN)
- Include a simple container/card for each opportunity
- Do NOT wrap the output in markdown or code fences
- The response must start with <!DOCTYPE html> and end with </html>
PROMPT;
    }

    /**
     * Call Gemini API
     */
    private function callGemini(string $prompt): array
    {
        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ];

        $ch = curl_init($this->endpoint);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 30
        ]);

        $rawResponse = curl_exec($ch);

        if ($rawResponse === false) {
            throw new RuntimeException('cURL error: ' . curl_error($ch));
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200) {
            throw new RuntimeException('Gemini API error: ' . $rawResponse);
        }

        $decoded = json_decode($rawResponse, true);

        if (!isset($decoded['candidates'][0]['content']['parts'][0]['text'])) {
            throw new RuntimeException('Invalid Gemini response structure');
        }

        return $decoded;
    }

    /**
     * Output raw HTML directly
     */
    private function outputHtml(array $data): void
    {
        $html = $data['candidates'][0]['content']['parts'][0]['text'];

        // Remove accidental code fences
        $html = preg_replace('/^```[a-zA-Z]*\s*/', '', $html);
        $html = preg_replace('/\s*```$/', '', $html);

        // Set content-type header for HTML
        header('Content-Type: text/html; charset=utf-8');
        echo trim($html);
    }
}

// ==================================================
// Bootstrap
// ==================================================
try {
    // Example: user-submitted interests from a form
    $userInterests = $_POST['interests'] ?? ['technology', 'business', 'marketing'];

    $generator = new GeminiPlanGenerator('AIzaSyCCCX43ElSOhFdpquzpAeJ6NB5kIEcRSRo');
    $generator->generateDailyOpportunities($userInterests);
} catch (Throwable $e) {
    http_response_code(500);
    echo "<h1>Error generating opportunities</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
