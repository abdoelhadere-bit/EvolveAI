<?php

session_start();


class GeminiService
{
    private static $apiKey;

    private static function getApiKey(): string
    {
        if (!self::$apiKey) {
            self::$apiKey = 'AIzaSyCCCX43ElSOhFdpquzpAeJ6NB5kIEcRSRo';

            if (!self::$apiKey) {
                throw new RuntimeException('Gemini API key is missing. Set GEMINI_API_KEY in .env');
            }
        }
        return self::$apiKey;
    }

    public static function generate(array $input): string
    {
        $prompt = <<<PROMPT
You are a senior UI engineer.

TASK:
Analyze the user's plan input and generate a DAILY ACTION PLAN interface.

STRICT OUTPUT RULES:
- Output ONLY a complete, valid HTML document
- No explanations
- No markdown
- No comments outside HTML
- Use Tailwind CSS via CDN
- Include all JavaScript inline

UI REQUIREMENTS:
- Title: "Daily Action Plan"
- Main Goal section
- Task checklist derived from input:
  - Checkbox per task
  - Checked items turn green
  - Checked items become disabled
- Progress bar that updates dynamically
- Progress percentage label
- Persist checkbox state using localStorage
- Notice section at the bottom
- Professional, clean layout
- Responsive design

USER PLAN INPUT:
{json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)}
PROMPT;

        $apiKey = self::getApiKey();

        $url = "https://gemini.googleapis.com/v1/models/gemini-2.5-flash:generate";

        $payload = [
            "prompt" => $prompt,
            "temperature" => 0.1,
            "max_output_tokens" => 2000
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer $apiKey",
            "Content-Type: application/json"
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new RuntimeException('cURL error: ' . curl_error($ch));
        }

        curl_close($ch);

        $data = json_decode($response, true);

        if (!isset($data['output_text'])) {
            throw new RuntimeException('Gemini did not return valid output: ' . $response);
        }

        return $data['output_text'];
    }
}


$input = json_decode(file_get_contents('php://input'), true);

if (!is_array($input)) {
    http_response_code(400);
    exit('Invalid JSON input');
}

try {
    $html = GeminiService::generate($input);
} catch (Exception $e) {
    http_response_code(500);
    exit("Error generating plan: " . $e->getMessage());
}

$_SESSION['daily_plan'] = $html;

header('Content-Type: text/html; charset=UTF-8');
echo $html;
