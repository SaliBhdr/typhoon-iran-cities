<?php

namespace SaliBhdr\TyphoonIranCities\Commands\Abstracts;

use Illuminate\Console\Command;

abstract class AbstractCommand extends Command
{
    /**
     * @param string $question
     * @return bool
     */
    protected function askBoolQuestion($question)
    {
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
