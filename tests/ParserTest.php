<?php

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function test_Parser_from_csv()
    {
        $parser = new Parser();
        $parser->createFromCsvFile(__DIR__ . "/fixtures/simpleMailList.csv");
        $data = $parser->getData();
        $this->assertTrue(is_array($data));

        $this->assertTrue(count($data) == 3);
        $this->assertEquals('Peter Parker', $data[0]['name']);
        $this->assertEquals('superlopez@gmail.com', $data[2]['email']);
        $expected = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.";
        $this->assertEquals($expected, $data[0]['body']);
    }
}