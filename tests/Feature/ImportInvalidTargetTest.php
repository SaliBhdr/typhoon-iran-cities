<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportInvalidTargetTest extends TestCase
{
    public function test_it_rejects_unknown_target(): void
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Target Region (unknown) Not Found');

        $this->artisan('iran:import', ['--target' => 'unknown']);
    }
}
