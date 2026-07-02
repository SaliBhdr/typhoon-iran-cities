<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Concerns;

use SaliBhdr\TyphoonIranCities\Commands\Import;

trait UsesFixtureCsv
{
    protected function bindFixtureCsv(): void
    {
        $fixturesPath = $this->fixturesPath();

        $this->app->resolving(Import::class, function (Import $command) use ($fixturesPath) {
            $command->useCsvFrom($fixturesPath);
        });
    }
}
