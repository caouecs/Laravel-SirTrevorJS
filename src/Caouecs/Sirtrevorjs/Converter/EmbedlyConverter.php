<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

/**
 * Embedly for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class EmbedlyConverter
{
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

            return $this->view("embedly.".$this->type, array(
                "url" => $this->data['url'],
                "options" => $this->config['embedly']
            ));
        }

        return null;
    }
}
