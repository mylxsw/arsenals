<?php

class DemoTest extends PHPUnit_Framework_TestCase
{
    public function testDemo2()
    {
        $num = 5;
        $this->assertEquals(5, $num);

        return $num;
    }

    /**
     * @depends testDemo2
     */
    public function testDemo1($num)
    {
        $this->assertEquals(5, $num);
    }

    /**
     * Enter description here ...
     *
     * @param $a
     * @param $b
     * @param $c
     * @dataProvider provider3Nums
     */
    public function testAdd($a, $b, $c)
    {
        $this->assertEquals($c, $a + $b);
    }

    public function provider3Nums()
    {
        return [
            [0, 0, 0],
            [1, 3, 4],
            [3, 3, 6],
            [2, 8, 10],
        ];
    }
}
