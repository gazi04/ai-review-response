<?php declare(strict_types=1);

namespace AiReviewRespond\Controller;

use AiReviewRespond\Service\ReviewAiService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route(defaults: ['_routeScope' => ['api']])]
class AiController extends AbstractController
{
    private ReviewAiService $aiService;

    public function __construct(ReviewAiService $aiService)
    {
        $this->aiService = $aiService;
    }

    #[Route(path: '/api/_action/ai-review/generate', name: 'api.action.ai_review.generate', methods: ['POST'])]
    public function generateReply(Request $request): JsonResponse
    {
        $reviewText = $request->get('reviewText', '');
        $rating = (int) $request->get('rating', 5);

        try {
            $draft = $this->aiService->generateReviewDraft($reviewText, $rating);
            return new JsonResponse(['draft' => $draft]);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], 500);
        }
    }
}
