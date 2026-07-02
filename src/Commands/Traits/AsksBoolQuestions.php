<?php

namespace SaliBhdr\TyphoonIranCities\Commands\Traits;

trait AsksBoolQuestions
{
    /**
     * @param string $question
     * @return bool
     */
    protected function askBoolQuestion($question)
    {
        if (!$this->input->isInteractive()) {
            return true;
        }

        $answer = strtolower($this->ask("$question (y/n)", 'y'));

        $answerMap = [
            'y'   => true,
            'yes' => true,
            'n'   => false,
            'no'  => false,
        ];

        if (isset($answerMap[$answer]))
            return $answerMap[$answer];

        return $this->askBoolQuestion($question);
    }
}
