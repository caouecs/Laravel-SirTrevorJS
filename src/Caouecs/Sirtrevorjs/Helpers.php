<?php namespace Caouecs\Sirtrevorjs;

class Helpers
{
    /**
     * Function to include javascript code
     *
     * @access public
     * @param string $code Javascript code
     * @return string
     *
     * @todo Change name of function
     */
    public static function jscode($code)
    {
        return '<script type="text/javascript">'.$code.'</script>'.PHP_EOL;
    }
}
