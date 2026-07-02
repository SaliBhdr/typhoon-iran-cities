<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Feature;

use Illuminate\Support\Facades\DB;
use SaliBhdr\TyphoonIranCities\Tests\Concerns\UsesFixtureCsv;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class ImportTest extends TestCase
{
    use UsesFixtureCsv;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bindFixtureCsv();
    }

    public function test_it_imports_provinces_into_separate_table(): void
    {
        $this->runMigrationStub('1_create_iran_provinces_table.stub');

        $this->artisan('iran:import', ['--target' => 'provinces'])->assertSuccessful();

        $this->assertSame(2, DB::table('iran_provinces')->count());
    }

    public function test_it_imports_counties_after_provinces(): void
    {
        $this->runMigrationStub('1_create_iran_provinces_table.stub');
        $this->runMigrationStub('2_create_iran_counties_table.stub');

        $this->artisan('iran:import', ['--target' => 'counties'])->assertSuccessful();

        $this->assertSame(2, DB::table('iran_provinces')->count());
        $this->assertSame(1, DB::table('iran_counties')->count());
    }

    public function test_fresh_option_truncates_before_reimport(): void
    {
        $this->runMigrationStub('1_create_iran_provinces_table.stub');

        $this->artisan('iran:import', ['--target' => 'provinces'])->assertSuccessful();
        $this->assertSame(2, DB::table('iran_provinces')->count());

        DB::table('iran_provinces')->insert([
            'id'         => 99,
            'name'       => 'Stale',
            'code'       => '99',
            'short_code' => '99',
            'status'     => 1,
        ]);

        $this->artisan('iran:import', [
            '--target' => 'provinces',
            '--fresh'  => true,
        ])->assertSuccessful();

        $this->assertSame(2, DB::table('iran_provinces')->count());
        $this->assertNull(DB::table('iran_provinces')->where('id', 99)->first());
    }

    public function test_it_fails_when_tables_are_missing(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Table iran_provinces does not exist');

        $this->artisan('iran:import', ['--target' => 'provinces']);
    }
}
