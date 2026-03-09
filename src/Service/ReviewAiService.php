<?php declare(strict_types=1);

namespace AiReviewRespond\Service;

use OpenAI;
use Shopware\Core\System\SystemConfig\SystemConfigService;

class ReviewAiService
{
    private SystemConfigService $systemConfigService;

    public function __construct(SystemConfigService $systemConfigService)
    {
        $this->systemConfigService = $systemConfigService;
    }

    public function generateReviewDraft(string $reviewText, int $rating): string
    {
        // 1. Fetch values from Shopware Plugin Config
        $endpoint = $this->systemConfigService->getString('AiReviewRespond.config.openaiEndpoint') ?: 'https://models.github.ai/inference';
        $model = $this->systemConfigService->getString('AiReviewRespond.config.openaiModel') ?: 'openai/gpt-4.1';
        $apiKey = $this->systemConfigService->getString('AiReviewRespond.config.openaiApiKey');

        if (empty($apiKey)) {
            throw new \Exception('API Token is missing in plugin settings.');
        }

        // 2. Initialize client with custom Base URI (equivalent to base_url in Python)
        $client = \OpenAI::factory()
            ->withBaseUri($endpoint)
            ->withApiKey($apiKey)
            ->make();

        // 3. Create the request
        $response = $client->chat()->create([
            'model' => $model,
            'messages' => [
                [
                    'role' => 'system', 
                    'content' => 'You are a professional shop manager. Reply to customer reviews politely.'
                ],
                [
                    'role' => 'user', 
                    'content' => "The customer gave a $rating-star rating and wrote: \"$reviewText\". Please write a response."
                ],
            ],
            'temperature' => 1.0,
            'top_p' => 1.0,
        ]);

        return $response->choices[0]->message->content ?? '';
    }
}
