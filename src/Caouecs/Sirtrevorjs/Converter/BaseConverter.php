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
 * Base of converters for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class BaseConverter
{
    /**
     * Config
     *
     * @var array
     * @access protected
     */
    protected $config = null;

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
     * Construct
     *
     * @access public
     * @param string $type Type of element
     * @param array $data Data of element
     */
    public function __construct($type, $data)
    {
        $this->type = $type;
        $this->data = $data;
        $this->config = Config::get("sirtrevorjs::sir-trevor-js");
    }

    /**
     * Render
     *
     * @access public
     * @param array $codejs Array with JS for Sir Trevor Js
     * @return string
     */
    public function render(&$codejs)
    {
        if (in_array($this->type, $this->types)) {
            return call_user_func_array(
                array($this, $this->type."ToHtml"),
                array($codejs)
            );
        }

        return null;
    }

    /**
     * Personalized views
     *
     * @access public
     * @param string $viewName Name of the base view
     * @param array $params Params
     */
    public function view($viewName, $params = array())
    {
        if (isset($this->config['view'])) {
            // verif if need :: or not
            if (View::exists($this->config['view'].".".$viewName)) {
                return View::make($this->config['view'].".".$viewName, $params);
            }
        }

        return View::make("sirtrevorjs::".$viewName, $params);
    }
}
