<?php

namespace Sweetmancc\DatabaseTrigger\Test;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Sweetmancc\DatabaseTrigger\Schema\MySqlBuilder as Builder;

class MySqlBuilderTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testTriggerCorrectlyCallsGrammar()
    {
        $connection = m::mock('Illuminate\Database\Connection');
        $grammar = m::mock('stdClass');
        $connection->shouldReceive('getSchemaGrammar')->andReturn($grammar);
        $builder = new Builder($connection);
        $connection->shouldReceive('select')->once()->andReturn(['trigger']);

        $this->assertTrue($builder->hasTrigger('trigger'));
    }
}
