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
You are an AI system specialized in market analysis and income opportunity discovery.

Analyze:
- Current digital market trends
- Freelancing platforms (such as Upwork, Fiverr, Malt, Freelancer, etc.)
- The user’s acquired skills and interests provided below

Your goal is to identify CONCRETE and REALISTIC income opportunities
that the user can pursue immediately.

User skills and interests:
{{USER_SKILLS_JSON}}

REQUIREMENTS:
- Generate a MAXIMUM of 5 opportunities for the current day
- Each opportunity MUST include:
  - A unique identifier
  - A clear and concise title
  - A short description (2–3 sentences)
  - Required skills (as a list)
  - Estimated earnings (range or monthly potential)
  - A relevant external link (freelance platform, resource, or marketplace)
  - A representative image URL
- Opportunities may include:
  - Freelance gigs
  - Micro-business ideas
  - AI-based projects or services
- Focus on realism, market demand, and feasibility

OUTPUT RULES:
- Return ONLY raw HTML
- Use ONLY:
  - HTML
  - Tailwind CSS (via CDN)
  - Vanilla JavaScript (optional)
- Structure the output as a feed or grid of opportunity cards
- Each card MUST include a visible “Explore” or “Select” button
- Do NOT use Markdown
- Do NOT wrap the output in code fences
- Do NOT add explanations or comments
- The response MUST start with <!DOCTYPE html> and end with </html>

PROMPT;
    }

        private function buildPlanPrompt(array $userCmd): string
    {
        // $interestsJson = json_encode($userCmd, JSON_UNESCAPED_UNICODE);

        return <<<PROMPT
You are an AI business and execution strategist.

The user has selected the following opportunity:
{{SELECTED_OPPORTUNITY_JSON}}

Your task is to generate a CLEAR, ACTIONABLE, and REALISTIC plan
to help the user successfully achieve this opportunity and generate income.

REQUIREMENTS:
- The plan MUST include:
  - A clear objective summary
  - Prerequisites (skills, tools, accounts, budget if any)
  - Step-by-step action plan (ordered)
  - Estimated timeline per step
  - Potential risks and how to mitigate them
  - Monetization strategy (how and when income is generated)
  - First concrete action the user should take today
- The plan should be practical and beginner-friendly
- Avoid theory and generic advice

OUTPUT RULES:
- Return ONLY raw HTML
- Use ONLY:
  - HTML
  - Tailwind CSS (via CDN)
  - Vanilla JavaScript (optional)
- Use sections, lists, and progress indicators if relevant
- Do NOT use Markdown
- Do NOT wrap the output in code fences
- Do NOT add explanations or comments
- The response MUST start with <!DOCTYPE html> and end with </html>

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

    $generator = new GeminiPlanGenerator('AIzaSyC_1XL9ORZNMbcugfCVslNTB9ce9l8D9v8');
    $generator->generateDailyOpportunities($userInterests);
} catch (Throwable $e) {
    http_response_code(500);
    echo "<h1>Error generating opportunities</h1><p>" . htmlspecialchars($e->getMessage()) . "</p>";
}
