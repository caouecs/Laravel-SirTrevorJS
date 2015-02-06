<?php
/**
 * Laravel-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\ConverterInterface;

/**
 * Embedly for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class EmbedlyConverter extends BaseConverter implements ConverterInterface
{
    /**
     * List of types
     *
     * @access protected
     * @var array
     */
    protected $types = array(
        "embedly"
    );

    /**
     * Render of embedly
     *
     * @access public
     * @param array $codejs Array of js
     * @return string
     */
    public function embedlyToHtml(&$codejs)
    {
        if (filter_var($this->data['url'], FILTER_VALIDATE_URL)) {
            $codejs['embedly'] = '<script async src="//cdn.embedly.com/widgets/platform.js" charset="UTF-8"></script>';

            return $this->view("embedly.".$this->type, array(
                "url" => $this->data['url'],
                "options" => array_get($this->config, 'embedly')
            ));
        }

        return null;
    }
}
