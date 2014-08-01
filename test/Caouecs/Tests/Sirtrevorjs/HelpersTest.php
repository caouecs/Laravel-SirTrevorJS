<?php namespace Caouecs\Tests\Sirtrevorjs;

use Caouecs\Sirtrevorjs\Helpers;

class HelpersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * test jscode of Helper
     *
     * @covers \Caouecs\Sirtrevorjs\Helpers::jscode
     */
    public function testJscode()
    {
        $test = "ok";

        $result = Helpers::jscode($test);

        $this->assertEquals(
            $result,
            '<script type="text/javascript">'.$test.'</script>'.PHP_EOL,
            'The html return is bad'
        );
    }
}
