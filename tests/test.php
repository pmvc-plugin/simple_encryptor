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
        $encode = '5VmH2Bi5XFcqrioDG9wHEg==';
        $p = \PMVC\plug($this->_plug, ['key'=>'key']);
        $result = $p->encode($test);
        $this->assertEquals($result, $encode);
    }

    function testDecode()
    {
        $test = 'abc';
        $encode = '5VmH2Bi5XFcqrioDG9wHEg==';
        $p = \PMVC\plug($this->_plug, ['key'=>'key']);
        $result = $p->decode($encode);
        $this->assertEquals($result, $test);
    }
}
