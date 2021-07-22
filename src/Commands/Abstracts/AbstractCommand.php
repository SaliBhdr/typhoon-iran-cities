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

    /**
     * @param $path
     * @return array|null
     * @throws \Exception
     */
    protected function csvToArray($path)
    {
        if (!$path || !file_exists($path))
            throw new \Exception('File ' . $path . ' not exists');

        $csv = array_map('str_getcsv', file($path));

        array_walk($csv, function (&$a) use ($csv) {
            $a = array_combine($csv[0], $a);
        });

        array_shift($csv);

        return $csv;
    }

    /**
     * prevents php throw error for importing very large data sets to database based on limits
     */
    protected function removePhpLimits()
    {
        @set_time_limit(0);
        @ini_set("memory_limit", "-1");
        @ini_set("max_execution_time", '-1');
        @ini_set('max_input_vars', '5000');
    }
}
