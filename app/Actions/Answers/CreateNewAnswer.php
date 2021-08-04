<?php

namespace App\Actions\Answers;

use App\Models\Question;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewAnswer
{
    use AsAction;

    private int $latestAnswerId;

    public function handle(Question $question): Question
    {
        $answers = $question->answers;

        $this->setLatestAnswerId($answers);

        $answers[$this->latestAnswerId] = Question::getAnswerOptionScaffolding($this->latestAnswerId);

        $question->update([
            'answers' => array_values($answers)
        ]);

        return $question;
    }

    protected function setLatestAnswerId(array $answers)
    {
        $this->latestAnswerId = 1;

        foreach ($answers as $answer) {
            if ($answer['id'] > $this->latestAnswerId) {
                $this->latestAnswerId = $answer['id'];
            }
        }

        $this->latestAnswerId += 1;
    }
}
