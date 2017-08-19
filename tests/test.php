<?php
namespace PMVC\PlugIn\simple_encryptor;

use PHPUnit_Framework_TestCase;

class Simple_encryptorTest extends PHPUnit_Framework_TestCase
{
    private $_plug = 'simple_encryptor';
    function testPlugin()
    {
        ob_start();
        print_r(\PMVC\plug($this->_plug));
        $output = ob_get_contents();
        ob_end_clean();
        $this->assertContains($this->_plug,$output);
    }

    function testEncode()
    {
        $test = 'abc';
        $encode = '5HLL|ptckpGYKVLJhd8jH0xJjnw==';
        $p = \PMVC\plug($this->_plug, [
            'key'=>'key',
            'iv'=>base64_decode('ptckpGYKVLJhd8jH0xJjnw==')
        ]);
        $result = $p->encode($test);
        $this->assertEquals( $encode, $result);
    }

    function testDecode()
    {
        $test = 'abc';
        $encode = '5HLL|ptckpGYKVLJhd8jH0xJjnw==';
        $p = \PMVC\plug($this->_plug, ['key'=>'key']);
        $result = $p->decode($encode);
        $this->assertEquals($test, $result);
    }
}
