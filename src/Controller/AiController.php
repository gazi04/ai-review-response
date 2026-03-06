<?php declare(strict_types=1);

namespace AiReviewRespond\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Shopware\Core\Framework\Context;

#[Route(defaults: ['_routeScope' => ['api']])]
class AiController extends AbstractController
{
    #[Route(path: '/api/_action/ai-review/generate', name: 'api.action.ai_review.generate', methods: ['POST'])]
    public function generateReply(Request $request, Context $context): JsonResponse
    {
        $reviewText = $request->get('reviewText', '');
        $rating = $request->get('rating', 5);

        if ($rating >= 4) {
            $draft = "Thank you for the wonderful $rating-star review! We are thrilled you liked it. Your feedback: '" . substr($reviewText, 0, 30) . "...' means a lot to us!";
        } else {
            $draft = "We are sorry to see your $rating-star rating. We take your feedback seriously and would love to make things right.";
        }

        return new JsonResponse(['draft' => $draft]);
    }
}
