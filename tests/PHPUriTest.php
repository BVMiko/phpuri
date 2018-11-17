<?php
namespace TXC\PHPUri\Tests;

/**
 * A php library for converting relative urls to absolute.
 * Website: https://github.com/monkeysuffrage/phpuri
 *
 * <pre>
 * echo phpUri::parse('https://www.google.com/')->join('foo');
 * //==> https://www.google.com/foo
 * </pre>
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @author  P Guardiario <pguardiario@gmail.com>
 * @version 1.0
 */

use PHPUnit\Framework\TestCase;
use TXC\PHPUri\PHPUri;


class PHPUriTest extends TestCase
{

    /** @test */
    public function check_http_protocol_url_against_array()
    {
        $tests = [
            ['rel' => 'g:h', 'result' => 'g:h'],
            ['rel' => 'g', 'result' => 'http://a/b/c/g'],
            ['rel' => './g', 'result' => 'http://a/b/c/g'],
            ['rel' => 'g/', 'result' => 'http://a/b/c/g/'],
            ['rel' => '/g', 'result' => 'http://a/g'],
            ['rel' => '//g', 'result' => 'http://g'],
            ['rel' => 'g?y', 'result' => 'http://a/b/c/g?y'],
            ['rel' => '#s', 'result' => 'http://a/b/c/d;p?q#s'],
            ['rel' => 'g#s', 'result' => 'http://a/b/c/g#s'],
            ['rel' => 'g?y#s', 'result' => 'http://a/b/c/g?y#s'],
            ['rel' => ';x', 'result' => 'http://a/b/c/;x'],
            ['rel' => 'g;x', 'result' => 'http://a/b/c/g;x'],
            ['rel' => 'g;x?y#s', 'result' => 'http://a/b/c/g;x?y#s'],
            ['rel' => '.', 'result' => 'http://a/b/c/'],
            ['rel' => './', 'result' => 'http://a/b/c/'],
            ['rel' => '..', 'result' => 'http://a/b/'],
            ['rel' => '../', 'result' => 'http://a/b/'],
            ['rel' => '../g', 'result' => 'http://a/b/g'],
            ['rel' => '../..', 'result' => 'http://a/'],
            ['rel' => '../../', 'result' => 'http://a/'],
            ['rel' => '../../g', 'result' => 'http://a/g'],
            ['rel' => 'g.', 'result' => 'http://a/b/c/g.'],
            ['rel' => '.g', 'result' => 'http://a/b/c/.g'],
            ['rel' => 'g..', 'result' => 'http://a/b/c/g..'],
            ['rel' => '..g', 'result' => 'http://a/b/c/..g'],
            ['rel' => './../g', 'result' => 'http://a/b/g'],
            ['rel' => './g/.', 'result' => 'http://a/b/c/g/'],
            ['rel' => 'g/./h', 'result' => 'http://a/b/c/g/h'],
            ['rel' => 'g/../h', 'result' => 'http://a/b/c/h'],
            ['rel' => 'g;x=1/./y', 'result' => 'http://a/b/c/g;x=1/y'],
            ['rel' => 'g;x=1/../y', 'result' => 'http://a/b/c/y'],
            ['rel' => 'g?y/./x', 'result' => 'http://a/b/c/g?y/./x'],
            ['rel' => 'g?y/../x', 'result' => 'http://a/b/c/g?y/../x'],
            ['rel' => 'g#s/./x', 'result' => 'http://a/b/c/g#s/./x'],
            ['rel' => 'g#s/../x', 'result' => 'http://a/b/c/g#s/../x']
        ];

        $base = phpUri::parse('http://a/b/c/d;p?q');

        foreach($tests as $test) {
            $r = ( $base->join($test['rel']) === $test['result'] );
            $this->assertTrue($r);
        }
    }

    /** @test */
    public function check_https_protocol_url_against_array()
    {
        $tests = [
            ['rel' => 'g:h', 'result' => 'g:h'],
            ['rel' => 'g', 'result' => 'https://a/b/c/g'],
            ['rel' => './g', 'result' => 'https://a/b/c/g'],
            ['rel' => 'g/', 'result' => 'https://a/b/c/g/'],
            ['rel' => '/g', 'result' => 'https://a/g'],
            ['rel' => '//g', 'result' => 'https://g'],
            ['rel' => 'g?y', 'result' => 'https://a/b/c/g?y'],
            ['rel' => '#s', 'result' => 'https://a/b/c/d;p?q#s'],
            ['rel' => 'g#s', 'result' => 'https://a/b/c/g#s'],
            ['rel' => 'g?y#s', 'result' => 'https://a/b/c/g?y#s'],
            ['rel' => ';x', 'result' => 'https://a/b/c/;x'],
            ['rel' => 'g;x', 'result' => 'https://a/b/c/g;x'],
            ['rel' => 'g;x?y#s', 'result' => 'https://a/b/c/g;x?y#s'],
            ['rel' => '.', 'result' => 'https://a/b/c/'],
            ['rel' => './', 'result' => 'https://a/b/c/'],
            ['rel' => '..', 'result' => 'https://a/b/'],
            ['rel' => '../', 'result' => 'https://a/b/'],
            ['rel' => '../g', 'result' => 'https://a/b/g'],
            ['rel' => '../..', 'result' => 'https://a/'],
            ['rel' => '../../', 'result' => 'https://a/'],
            ['rel' => '../../g', 'result' => 'https://a/g'],
            ['rel' => 'g.', 'result' => 'https://a/b/c/g.'],
            ['rel' => '.g', 'result' => 'https://a/b/c/.g'],
            ['rel' => 'g..', 'result' => 'https://a/b/c/g..'],
            ['rel' => '..g', 'result' => 'https://a/b/c/..g'],
            ['rel' => './../g', 'result' => 'https://a/b/g'],
            ['rel' => './g/.', 'result' => 'https://a/b/c/g/'],
            ['rel' => 'g/./h', 'result' => 'https://a/b/c/g/h'],
            ['rel' => 'g/../h', 'result' => 'https://a/b/c/h'],
            ['rel' => 'g;x=1/./y', 'result' => 'https://a/b/c/g;x=1/y'],
            ['rel' => 'g;x=1/../y', 'result' => 'https://a/b/c/y'],
            ['rel' => 'g?y/./x', 'result' => 'https://a/b/c/g?y/./x'],
            ['rel' => 'g?y/../x', 'result' => 'https://a/b/c/g?y/../x'],
            ['rel' => 'g#s/./x', 'result' => 'https://a/b/c/g#s/./x'],
            ['rel' => 'g#s/../x', 'result' => 'https://a/b/c/g#s/../x']
        ];

        $base = phpUri::parse('https://a/b/c/d;p?q');

        foreach($tests as $test) {
            $r = ( $base->join($test['rel']) === $test['result'] );
            $this->assertTrue($r);
        }
    }

    /** @test */
    public function check_protocol_relative_url_against_array()
    {
        $tests = [
            ['rel' => 'g:h', 'result' => 'g:h'],
            ['rel' => 'g', 'result' => '//a/b/c/g'],
            ['rel' => './g', 'result' => '//a/b/c/g'],
            ['rel' => 'g/', 'result' => '//a/b/c/g/'],
            ['rel' => '/g', 'result' => '//a/g'],
            ['rel' => '//g', 'result' => '//g'],
            ['rel' => 'g?y', 'result' => '//a/b/c/g?y'],
            ['rel' => '#s', 'result' => '//a/b/c/d;p?q#s'],
            ['rel' => 'g#s', 'result' => '//a/b/c/g#s'],
            ['rel' => 'g?y#s', 'result' => '//a/b/c/g?y#s'],
            ['rel' => ';x', 'result' => '//a/b/c/;x'],
            ['rel' => 'g;x', 'result' => '//a/b/c/g;x'],
            ['rel' => 'g;x?y#s', 'result' => '//a/b/c/g;x?y#s'],
            ['rel' => '.', 'result' => '//a/b/c/'],
            ['rel' => './', 'result' => '//a/b/c/'],
            ['rel' => '..', 'result' => '//a/b/'],
            ['rel' => '../', 'result' => '//a/b/'],
            ['rel' => '../g', 'result' => '//a/b/g'],
            ['rel' => '../..', 'result' => '//a/'],
            ['rel' => '../../', 'result' => '//a/'],
            ['rel' => '../../g', 'result' => '//a/g'],
            ['rel' => 'g.', 'result' => '//a/b/c/g.'],
            ['rel' => '.g', 'result' => '//a/b/c/.g'],
            ['rel' => 'g..', 'result' => '//a/b/c/g..'],
            ['rel' => '..g', 'result' => '//a/b/c/..g'],
            ['rel' => './../g', 'result' => '//a/b/g'],
            ['rel' => './g/.', 'result' => '//a/b/c/g/'],
            ['rel' => 'g/./h', 'result' => '//a/b/c/g/h'],
            ['rel' => 'g/../h', 'result' => '//a/b/c/h'],
            ['rel' => 'g;x=1/./y', 'result' => '//a/b/c/g;x=1/y'],
            ['rel' => 'g;x=1/../y', 'result' => '//a/b/c/y'],
            ['rel' => 'g?y/./x', 'result' => '//a/b/c/g?y/./x'],
            ['rel' => 'g?y/../x', 'result' => '//a/b/c/g?y/../x'],
            ['rel' => 'g#s/./x', 'result' => '//a/b/c/g#s/./x'],
            ['rel' => 'g#s/../x', 'result' => '//a/b/c/g#s/../x']
        ];

        $base = phpUri::parse('//a/b/c/d;p?q');

        foreach($tests as $test) {
            $r = ( $base->join($test['rel']) === $test['result'] );
            $this->assertTrue($r);
        }
    }
}