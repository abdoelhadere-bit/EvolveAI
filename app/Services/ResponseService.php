<?php

namespace App\Services;

use RuntimeException;

final class ResponseService
{
    private const MODEL = 'gemini-3-flash-preview';
    private static string $apiKey = 'AIzaSyByCYagoASaF9M-TrH7glCIEQ5GwOgD0p0';

    private static function buildUrl(): string
    {
        return sprintf(
            'https://generativelanguage.googleapis.com/v1beta/models/%s:generateContent?key=%s',
            self::MODEL,
            self::$apiKey
        );
    }

    private static function makeApiCall(string $prompt): string
    {
        $payload = [
            'contents' => [['parts' => [['text' => $prompt]]]]
        ];

        $ch = curl_init(self::buildUrl());
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 60
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            throw new RuntimeException('Curl error: ' . curl_error($ch));
        }
        
        curl_close($ch);
        $data = json_decode($response, true);

        if (isset($data['error'])) {
            throw new RuntimeException('Gemini API Error: ' . ($data['error']['message'] ?? 'Unknown error'));
        }

        if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
            throw new RuntimeException('Invalid API response structure.');
        }

        $html = $data['candidates'][0]['content']['parts'][0]['text'];

        // Clean up Markdown and tags
        $html = preg_replace('/^```html/i', '', $html);
        $html = preg_replace('/^```/', '', $html);
        $html = preg_replace('/```$/', '', $html);
        $html = preg_replace('/<!DOCTYPE html>/i', '', $html);
        $html = preg_replace('/<\/?html[^>]*>/i', '', $html);
        $html = preg_replace('/<\/?body[^>]*>/i', '', $html);
        $html = preg_replace('/<\/?head[^>]*>.*?<\/head>/si', '', $html); 

        return trim($html);
    }

    private static function parseJson(string $jsonStr): array
    {
        // Sanitize
        $jsonStr = preg_replace('/^```json/i', '', $jsonStr);
        $jsonStr = preg_replace('/^```/', '', $jsonStr);
        $jsonStr = preg_replace('/```$/', '', $jsonStr);
        
        $data = json_decode($jsonStr, true);
        return is_array($data) ? $data : [];
    }

    // GENERATE OPPORTUNITIES
    
    // GENERATE OPPORTUNITIES
    
    public static function generateOpportunities(array $userProfile): array
    {
        $inputJson = json_encode($userProfile, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        $prompt = <<<PROMPT
            You are an Elite Career Strategist. Analyze these user skills:
            $inputJson

            Identify 6 HIGH-VALUE, CONCRETE income opportunities.

            OUTPUT REQUIREMENTS:
            - **Output ONLY valid JSON.**
            - **Format:** Array of objects.
            - **Fields:** 
                - "title": Short, catchy title.
                - "description": Brief explanation (1-2 sentences).
                - "estimated_earnings": e.g. "$500 - $1000 / month".
                - "why_fit": One sentence explaining match.
            - **NO Markdown.**
            
            Example:
            [
                {"title": "Freelance Writer", "description": "...", "estimated_earnings": "...", "why_fit": "..."}
            ]
            PROMPT;

        $jsonStr = self::makeApiCall($prompt);
        return self::parseJson($jsonStr);
    }

    // GENERATE EXECUTION PLAN 
    public static function generateExecutionPlan(array $selectedData, int $dayNumber = 1): array
    {
        $opportunityJson = json_encode($selectedData, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        $prompt = <<<PROMPT
        You are an expert Productivity Coach.
        The user is on **DAY $dayNumber** of their journey.

        Selected Opportunity:
        $opportunityJson

        Create a **Dynamic Action Plan** for **DAY $dayNumber**.

        ### STRUCTURE:
        Create 4-6 actionable tasks.

        ### OUTPUT REQUIREMENTS:
        - **Output ONLY valid JSON.**
        - **Format:** Array of objects.
        - **Fields per task:**
            - "title": Actionable title.
            - "description": Instructions.
            - "estimated_minutes": Integer (e.g. 30).
            - "skill_tag": e.g. "Market Research".
            - "type": One of "learning", "action", "deliverable".
        - **NO Markdown.**
        
        Example:
        [
            {"title": "Research Competitors", "description": "Find top 3...", "estimated_minutes": 60, "skill_tag": "Research", "type": "action"}
        ]
        PROMPT;
            
        $jsonStr = self::makeApiCall($prompt);
        return self::parseJson($jsonStr);
    }

    // =========================================================================
    // METHOD 3: GENERATE EDUCATIONAL ARTICLES (JSON Output)
    // =========================================================================
    // =========================================================================
    // METHOD 3: GENERATE EDUCATIONAL ARTICLES (JSON Output)
    // =========================================================================
    public static function generateArticlesContext(array|string $currentPlan): array
    {
        // Handle structured plan (Array) vs legacy HTML (String)
        $planText = '';
        if (is_array($currentPlan)) {
            // Convert tasks array to string context
            $tasks = $currentPlan['tasks'] ?? [];
            foreach ($tasks as $t) {
                $planText .= "- Task: {$t['title']} ({$t['description']})\n";
            }
        } else {
            $planText = strip_tags($currentPlan);
        }

        $prompt = <<<PROMPT
You are an AI Learning Assistant.
Based on the user's daily plan below, generate 2 SHORT educational articles to help them achieve these specific tasks.

USER PLAN CONTEXT:
$planText

REQUIREMENTS:
- Return ONLY valid JSON.
- The JSON must be an array of objects.
- Each object must have: "title", "content" (2-3 paragraphs, simple formatting), and "links" (a list of 2 relevant URL suggestions).
- DO NOT use Markdown formatting in the response (no ```json).
- Example format:
[
  {
    "title": "Understanding MVC",
    "content": "MVC stands for...",
    "links": "https://wikipedia.org, https://youtube.com"
  }
]
PROMPT;

        $jsonStr = self::makeApiCall($prompt);

        // Sanitize if AI adds markdown fences despite instructions
        $jsonStr = preg_replace('/^```json/i', '', $jsonStr);
        $jsonStr = preg_replace('/^```/', '', $jsonStr);
        $jsonStr = preg_replace('/```$/', '', $jsonStr);

        $data = json_decode($jsonStr, true);

        if (!is_array($data)) {
            // Fallback if AI fails to give JSON
            return [];
        }
        

        return $data;
    }
    // ... (Keep existing methods) ...

    // =========================================================================
    // METHOD 4: ANALYZE TASK SUBMISSION (Feedback Loop)
    // =========================================================================
    // =========================================================================
    // METHOD 4: ANALYZE TASK SUBMISSION (Feedback Loop)
    // =========================================================================
    public static function analyzeTaskSubmission(array|string $planContext, string $taskTitle, string $userWork): array
    {
        // Handle structured plan (Array) vs legacy HTML (String)
        $contextClean = '';
        if (is_array($planContext)) {
             $tasks = $planContext['tasks'] ?? [];
             foreach ($tasks as $t) {
                 $contextClean .= "- Task: {$t['title']} ({$t['description']})\n";
             }
        } else {
             $contextClean = strip_tags($planContext);
        }

        $prompt = <<<PROMPT
You are a strict but encouraging AI Mentor.
The user is submitting work for a task from their Daily Plan.

CONTEXT (The User's Plan):
$contextClean

THE TASK BEING SUBMITTED:
"$taskTitle"

THE USER'S WORK/SUBMISSION:
"$userWork"

YOUR GOAL:
1. Evaluate if the work satisfies the task.
2. Provide a score (0-100).
3. Give specific, constructive feedback.

OUTPUT JSON ONLY:
{
    "score": 85,
    "feedback": "Great start! You correctly identified X, but you missed Y...",
    "status": "approved" (or "needs_revision")
}
PROMPT;

        $jsonStr = self::makeApiCall($prompt);

        // Sanitize JSON
        $jsonStr = preg_replace('/^```json/i', '', $jsonStr);
        $jsonStr = preg_replace('/^```/', '', $jsonStr);
        $jsonStr = preg_replace('/```$/', '', $jsonStr);

        $data = json_decode($jsonStr, true);

        return is_array($data) ? $data : [
            'score' => 0, 
            'feedback' => 'AI could not process this submission.', 
            'status' => 'error'
        ];
    }
}
