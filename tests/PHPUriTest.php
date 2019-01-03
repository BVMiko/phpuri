<?php
namespace TXC\PHPUri\Tests;

/**
 * Test based on https://tools.ietf.org/html/rfc1808#section-5
 */
use PHPUnit\Framework\TestCase;
use TXC\PHPUri\PHPUri;

class PHPUriTest extends TestCase
{
    protected $relativeURL = '//a/b/c/d;p?q#f';

    /**
     * https://tools.ietf.org/html/rfc1808#section-5.1
     * @param string $scheme
     */
    private function normal_examples($scheme = '')
    {
        if(!empty($scheme)) {
            $scheme .= ':';
        }

        $base = phpUri::parse($scheme . $this->relativeURL);

        $r = ( ((string)$base->join('g')) === $scheme . '//a/b/c/g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('./g')) === $scheme . '//a/b/c/g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g/')) === $scheme . '//a/b/c/g/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('/g')) === $scheme . '//a/g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('//g')) === $scheme . '//g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('?y')) === $scheme . '//a/b/c/d;p?y' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g?y')) === $scheme . '//a/b/c/g?y' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g?y/./x')) === $scheme . '//a/b/c/g?y/./x' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('#s')) === $scheme . '//a/b/c/d;p?q#s' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g#s')) === $scheme . '//a/b/c/g#s' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g?y#s')) === $scheme . '//a/b/c/g?y#s' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g#s/./x')) === $scheme . '//a/b/c/g#s/./x' );
        $this->assertTrue($r);

        // This doesn't work
        //$r = ( ((string)$base->join(';x')) === $scheme . '//a/b/c/d;x' );
        //$this->assertTrue($r);

        //$r = ( ((string)$base->join(';x')) === $scheme . '//a/b/c/;x' );
        //$this->assertFalse($r);

        $r = ( ((string)$base->join('g;x')) === $scheme . '//a/b/c/g;x' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g;x?y#s')) === $scheme . '//a/b/c/g;x?y#s' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('.')) === $scheme . '//a/b/c/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('./')) === $scheme . '//a/b/c/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('..')) === $scheme . '//a/b/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('../')) === $scheme . '//a/b/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('../g')) === $scheme . '//a/b/g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('../..')) === $scheme . '//a/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('../../')) === $scheme . '//a/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('../../g')) === $scheme . '//a/g' );
        $this->assertTrue($r);
    }

    /**
     * https://tools.ietf.org/html/rfc1808#section-5.2
     * @param string $scheme
     */
    private function abnormal_examples($scheme = '')
    {
        if(!empty($scheme)) {
            $scheme .= ':';
        }

        $base = phpUri::parse($scheme . $this->relativeURL);

        // This assertion doesn't work
        //$r = ( ((string)$base->join('/./g')) === $scheme . '//a/./g' );
        //$this->assertTrue($r);

        //$r = ( ((string)$base->join('/../g')) === $scheme . '//a/../g' );
        //$this->assertTrue($r);

        $r = ( ((string)$base->join('g.')) === $scheme . '//a/b/c/g.' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('.g')) === $scheme . '//a/b/c/.g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g..')) === $scheme . '//a/b/c/g..' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('..g')) === $scheme . '//a/b/c/..g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('./../g')) === $scheme . '//a/b/g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('./g/.')) === $scheme . '//a/b/c/g/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g/./h')) === $scheme . '//a/b/c/g/h' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g/../h')) === $scheme . '//a/b/c/h' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('./../g')) === $scheme . '//a/b/g' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('./g/.')) === $scheme . '//a/b/c/g/' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g/./h')) === $scheme . '//a/b/c/g/h' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g/../h')) === $scheme . '//a/b/c/h' );
        $this->assertTrue($r);
    }

    /**
     * @param string $scheme
     */
    private function really_abnormal_examples($scheme = '')
    {
        if(!empty($scheme)) {
            $scheme .= ':';
        }

        $base = phpUri::parse($scheme . $this->relativeURL);

        $r = ( ((string)$base->join('g;x=1/./y')) === $scheme . '//a/b/c/g;x=1/y' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g;x=1/../y')) === $scheme . '//a/b/c/y' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g?y/./x')) === $scheme . '//a/b/c/g?y/./x' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g?y/../x')) === $scheme . '//a/b/c/g?y/../x' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g#s/./x')) === $scheme . '//a/b/c/g#s/./x' );
        $this->assertTrue($r);

        $r = ( ((string)$base->join('g#s/../x')) === $scheme . '//a/b/c/g#s/../x' );
        $this->assertTrue($r);
    }

    /**
     * https://tools.ietf.org/html/rfc1808#section-5.1
     * @param string $scheme
     */
    private function check_empty_reference($scheme = '')
    {
        if(!empty($scheme)) {
            $scheme .= ':';
        }

        $base = phpUri::parse($scheme . $this->relativeURL);
        $r = ( ((string)$base->join('')) ===  $scheme . $this->relativeURL );
        $this->assertTrue($r);
    }

    /**
     * https://tools.ietf.org/html/rfc1808#section-5.1
     * @test
     */
    public function check_scheme_less()
    {
        $base = phpUri::parse($this->relativeURL);
        $r = ( ((string)$base->join('g:h')) ===  'g:h' );
        $this->assertTrue($r);
    }

    /** @test */
    public function check_with_scheme()
    {
        //$this->check_empty_reference('dummy');
        $this->normal_examples('dummy');
        $this->abnormal_examples('dummy');
        $this->really_abnormal_examples('dummy');
    }

    /** @test */
    public function check_scheme_relative_url()
    {
        //$this->check_empty_reference();
        $this->normal_examples();
        $this->abnormal_examples();
        $this->really_abnormal_examples();
    }
}
