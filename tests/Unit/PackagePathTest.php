<?php

namespace SaliBhdr\TyphoonIranCities\Tests\Unit;

use RuntimeException;
use SaliBhdr\TyphoonIranCities\Support\PackagePath;
use SaliBhdr\TyphoonIranCities\Tests\TestCase;

class PackagePathTest extends TestCase
{
    public function test_root_returns_package_directory(): void
    {
        $this->assertSame(dirname(__DIR__, 2), PackagePath::root());
    }

    public function test_stubs_returns_resolved_stub_directories(): void
    {
        $root = PackagePath::root();

        $this->assertSame(realpath($root . '/stubs'), PackagePath::stubs());
        $this->assertSame(realpath($root . '/stubs/migrations'), PackagePath::stubs('migrations'));
        $this->assertSame(realpath($root . '/stubs/models'), PackagePath::stubs('models'));
    }

    public function test_stubs_throws_when_segment_does_not_exist(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Package stubs path not found:');

        PackagePath::stubs('missing-segment');
    }

    public function test_csv_returns_package_csv_directory(): void
    {
        $this->assertSame(
            PackagePath::root() . DIRECTORY_SEPARATOR . 'csv',
            PackagePath::csv()
        );
    }
}
