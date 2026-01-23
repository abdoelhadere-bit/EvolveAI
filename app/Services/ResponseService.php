<?php

namespace App\Services;

use RuntimeException;

final class ResponseService
{
    private const MODEL = 'gemini-2.5-flash';
    private static string $apiKey = 'AIzaSyC_1XL9ORZNMbcugfCVslNTB9ce9l8D9v8';

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
            CURLOPT_TIMEOUT => 45
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

        $html = preg_replace('/^```html/i', '', $html);
        $html = preg_replace('/^```/', '', $html);
        $html = preg_replace('/```$/', '', $html);

        return trim($html);
    }

    // =========================================================================
    // METHOD 1: GENERATE OPPORTUNITIES (The Grid)
    // =========================================================================
    public static function generateOpportunities(array $userProfile): string
    {
        $inputJson = json_encode($userProfile, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        $prompt = <<<PROMPT
You are an AI system specialized in market analysis.
Analyze these user skills/interests:
$inputJson

Identify 4-5 CONCRETE income opportunities.

OUTPUT REQUIREMENTS:
- Return ONLY raw HTML (<!DOCTYPE html>...).
- Use Tailwind CSS.
- Display a GRID of cards.
- **CRITICAL:** Each card MUST contain a HTML Form to select that opportunity.
- The form MUST look like this:
  <form action="/EvolveAi/response/plan" method="POST">
      <input type="hidden" name="opportunity_title" value="[Insert Title Here]">
      <input type="hidden" name="opportunity_desc" value="[Insert Description]">
      <input type="hidden" name="opportunity_context" value="[Insert Skills/Earnings]">
      <button type="submit" class="[Tailwind Button Classes]">Generate Action Plan</button>
  </form>

PROMPT;

        return self::makeApiCall($prompt);
    }

    // =========================================================================
    // METHOD 2: GENERATE EXECUTION PLAN (The Detail View)
    // =========================================================================
    public static function generateExecutionPlan(array $selectedData): string
    {
        $opportunityJson = json_encode($selectedData, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE);

        $prompt = <<<PROMPT
You are an expert Productivity Coach. The user selected this opportunity:
$opportunityJson

Create a detailed "Roadmap to Success" Dashboard for this specific opportunity.

REQUIREMENTS:
1. **Structure:**
   - **Executive Summary:** Brief overview.
   - **Monthly Milestones:** High-level goals (Month 1, Month 2, etc.) depending on complexity.
   - **Weekly Breakdown:** What to achieve each week.
   - **Daily Routine:** A specific daily schedule (Morning/Afternoon/Evening) to achieve the weekly goals.
   
2. **Technical:**
   - Output COMPLETE HTML (<!DOCTYPE html>...).
   - Use Tailwind CSS.
   - Include Checkboxes for tasks.
   - Include a Progress Bar.
   - Style it as a professional dashboard.

OUTPUT HTML ONLY.
PROMPT;

        return self::makeApiCall($prompt);
    }
}