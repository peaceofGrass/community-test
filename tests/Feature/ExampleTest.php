<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testAaa()
    {
//        echo phpinfo();
        $a = 'aaa';
        $b = array(
            'one' => 'a',
            'two' => 'b'
        );

        echo ${$b['one']};

//        echo "<pre>";
//        print_r("<pre>");
//        print_r($b);
//        echo "</pre>";
    }

    public function testAab() {
//        $a = array(
//            'a' => 0
//        );
        $a = array();
        var_dump(empty($a));
    }

    public function testAac() {
        $a = [1,2];
//        echo "test" . $a[0];
        echo "test {$a[0]}";
    }

    public function testAad() {
        $a = 'abcdefg';
        $iPos = strpos($a, 'cd');
        var_dump($iPos);
    }

    public function testAae() {
        $a = 'abcdefg';
        $b = str_replace('a', 'b', $a);
        var_dump($b);
    }

    public function testAaf() {
        $a = 'hahahah<img src="http://baidu.com/aaa" alt=""> 바이두의 이미지 <p>lolo</p>';
        $sPattern = '/<.*>/i';
        $b = preg_replace($sPattern, '', $a);

        $c = strip_tags($a);

        echo $c;
    }
}
