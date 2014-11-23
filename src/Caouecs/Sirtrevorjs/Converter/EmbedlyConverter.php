<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Config;
use View;

/**
 * Embedly for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class EmbedlyConverter
{
    /**
     * Type of embedly
     *
     * @var string
     * @access protected
     */
    protected $type = null;

    /**
     * Data of embedly
     *
     * @var array
     * @access protected
     */
    protected $data = null;

    /**
     * List of types for embedly
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "card"
    );

    /**
     * Construct
     *
     * @access public
     * @param string $type Type of embedly
     * @param array $data Data of embedly
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Render of embedly
     *
     * @access public
     * @param array $codejs Array of js
     * @return string
     */
    public function render(&$codejs)
    {
        if (
            filter_var($this->data['url'], FILTER_VALIDATE_URL) &&
            in_array($this->type, $this->types)
        ) {
            $codejs['embedly'] = '<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>';

            return View::make("sirtrevorjs::embedly.".$this->type, array(
                "url" => $this->data['url'],
                "options" => Config::get("sirtrevorjs::sir-trevor-js.embedly")
            ));
        }

        return null;
    }
}
