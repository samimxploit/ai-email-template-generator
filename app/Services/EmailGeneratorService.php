<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class EmailGeneratorService
{
    public function generateEmail(string $purpose, string $recipientName, string $tone)
    {
        $prompt = "Generate a short, customer-friendly email based on the following details.

            Purpose: {$purpose}
            Recipient Name: {$recipientName}
            Tone: {$tone}

            Requirements:
            - Keep the email concise.
            - Use the requested tone.
            - Address the recipient by name.
            - Return only the email body.
            - Do not add explanations or notes.";

        $startTime = microtime(true);
        
        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'user',
                        'content' => $prompt,
                    ],
                ],
            ]);

            $generatedEmail = $response->choices[0]->message->content;

            $endTime = microtime(true);
            $responseTime = round($endTime - $startTime, 3);

            return [
                'email' => $generatedEmail,
                'response_time' => $responseTime,
            ];
        } catch (\Throwable $e) {
            throw new \RuntimeException(
                'Unable to generate email at this time.',
                0,
                $e
            );
        }
    }
}