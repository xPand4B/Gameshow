<?php

namespace App\Actions\Answers;

use App\Http\Resources\Error\ErrorResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteAnswer
{
    use AsAction;

    public function handle(Question $question, int $answerIdToDelete): ?JsonResponse
    {
        $answers = $question->answers;

        if (count($answers) === 2) {
            return $this->generateErrorResource('At least two answer options are necessary.');
        }

        if (count($answers) < $answerIdToDelete) {
            return $this->generateErrorResource("Answer with id '$answerIdToDelete' does not exist.");
        }

        foreach ($answers as $index => $answer) {
            if ($answer['id'] === $answerIdToDelete) {
                array_splice($answers, $index, 1);
                break;
            }
        }

        $question->update([
            'answers' => array_values($answers)
        ]);

        return null;
    }

    protected function generateErrorResource(string $message): JsonResponse
    {
        return (new ErrorResource())
            ->setSource('/database/models/answer')
            ->setDetail($message)
            ->setStatusCode(403)
            ->getError();
    }
}
