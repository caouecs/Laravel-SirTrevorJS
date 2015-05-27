<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @link https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use View;

/**
 * Base of converters for Sir Trevor Js.
 */
class BaseConverter
{
    /**
     * Parser instance
     */
    protected $parser = null;

    /**
     * Config of Sir Trevor Js.
     *
     * @var array
     */
    protected $config = null;

    /**
     * Type of block.
     *
     * @var string
     */
    protected $type = null;

    /**
     * Data of block.
     *
     * @var array
     */
    protected $data = null;

    /**
     * Construct.
     *
     * @param mixed $parser Parser instance
     * @param array $config Config of Sir Trevor Js
     * @param array $data   Data of element
     */
    public function __construct($parser, $config, $data)
    {
        $this->parser = $parser;
        $this->type = array_get($data, 'type');
        $this->data = array_get($data, 'data');
        $this->config = $config;
    }

    /**
     * Render.
     *
     * @param array $codejs Array with JS for Sir Trevor Js
     *
     * @return string
     */
    public function render(&$codejs)
    {
        if (in_array($this->type, $this->types)) {
            $method = $this->type.'ToHtml';

            return $this->$method($codejs);
        }

        return;
    }

    /**
     * Personalized views.
     *
     * @param string $viewName Name of the base view
     * @param array  $params   Params
     */
    public function view($viewName, $params = [])
    {
        if (isset($this->config['view']) && View::exists($this->config['view'].'.'.$viewName)) {
            return View::make($this->config['view'].'.'.$viewName, $params);
        }

        return View::make('sirtrevorjs::'.$viewName, $params);
    }
}
