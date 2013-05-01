<?php

namespace GingerLight\Tests;

use GingerLight\Parser;

/**
 * ParserTest.
 *
 * @package GingerLight
 * @author  Abdellatif Ait boudad <a.aitboudad@gmail.com>
 */
class ParserTest extends \PHPUnit_Framework_TestCase
{
    protected $parser;
    protected $customParser;
 
    protected function setUp()
    {
        $this->parser = new Parser();
    }

    public function testParsedResults()
    {
        $text   = 'The smelt of fliwers bring back memories.';
        $result = $this->parser->parse($text);
        var_dump($result);die;
        $this->assertEquals($text, $result['text']);
        $this->assertEquals('The smell of flowers brings back memories.', $result['result']);
        $this->assertEquals(3, count($result['corrections']));
        $this->assertEquals(4, $result['corrections'][0]['start']);
        $this->assertEquals(5, $result['corrections'][0]['length']);
    }
}