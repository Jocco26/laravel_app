<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Title;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    /*public function testTitlesModelCount()
    {
        $titles = new TItle;
        //$value = 1;
        //$this->assertTrue( 1=== $value, 'Value should be 1 ' );
        $this->assertTrue( count( $titles->all() ) === 6, 'It should have 6 titles'); 
    }

    public function testLastTitlesShouldBeProfessor()
    {
        $titles = new TItle;
        $titles_array = $titles->all();
        $this->assertEquals('Professor', array_pop( $titles_array), 'last item should be professor');
    }*/
}
