<?php

namespace Tests\Unit;

use App\Models\MasterClass;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Mockery;
use PHPUnit\Framework\TestCase;

class MasterClassTest extends TestCase
{
    public function test_calculates_available_spots()
    {
        $masterClass = Mockery::mock(MasterClass::class)->makePartial();
        $masterClass->capacity = 10;

        $enrollmentsMock = Mockery::mock(HasMany::class);
        $enrollmentsMock->shouldReceive('count')->andReturn(3);

        $masterClass->shouldReceive('enrollments')->andReturn($enrollmentsMock);

        $this->assertEquals(7, $masterClass->available_spots);
    }
}
