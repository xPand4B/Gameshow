<?php

namespace App\Actions\Questions;

use App\Models\Question;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateQuestion
{
    use AsAction;

    /**
     * @var mixed
     */
    private $fieldValue;
    private string $fieldName;
    private Question $question;

    public function handle(Request $request, Question $question): Question
    {
        $this->fieldValue = $request->get('value');
        $this->fieldName  = $request->get('name');
        $this->question   = $question;

        // If field is question, update. Otherwise, update answer by given id.
        if (!$this->updateIfFieldIsQuestion()) {
            $this->updateAnswerById($request->get('answerId'));
        }

        return $this->question;
    }

    protected function updateIfFieldIsQuestion(): bool
    {
        if ($this->fieldName !== 'question') {
            return false;
        }

        $this->question->update([
            'question' => $this->fieldValue
        ]);

        return true;
    }

    protected function updateAnswerById(int $answerId): void
    {
        $answers = $this->question->answers;
        $answerIndexIfPresent = array_search($answerId, array_column($answers, 'id'));

        if ($answerIndexIfPresent === false) {
            return;
        }

        $answers[$answerIndexIfPresent][$this->fieldName] = $this->fieldValue;
        $answers[$answerIndexIfPresent]['updated_at'] = now()->toDateTimeString();

        $this->question->update([
            'answers' => array_values($answers)
        ]);
    }
}
