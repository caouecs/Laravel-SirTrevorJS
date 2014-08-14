<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs;

/**
 * Helpers
 *
 * @package Caouecs\Sirtrevorjs
 */
class Helpers
{
    /**
     * Function to include javascript code
     *
     * @access public
     * @param string $code Javascript code
     * @return string
     * @static
     */
    public static function jscode($code)
    {
        return '<script type="text/javascript">'.$code.'</script>'.PHP_EOL;
    }
}
