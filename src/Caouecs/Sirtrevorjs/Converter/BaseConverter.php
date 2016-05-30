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
     * Parser instance.
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
     * List of types.
     *
     * @var array
     */
    protected $types = [];

    /**
     * Data of block.
     *
     * @var array
     */
    protected $data = null;

    /**
     * View.
     *
     * @var string
     */
    protected $view;

    /**
     * Output format.
     *
     * @var string
     */
    protected $output = 'html';

    /**
     * Code js.
     *
     * @var array
     */
    protected $codejs;

    /**
     * Construct.
     *
     * @param mixed $parser Parser instance
     * @param array $config Config of Sir Trevor Js
     * @param array $data   Data of element
     */
    public function __construct($parser, array $config, array $data, $output = 'html')
    {
        $this->parser = $parser;
        $this->type = array_get($data, 'type');
        $this->data = array_get($data, 'data');
        $this->config = $config;
        $this->output = $output;
    }

    /**
     * Render.
     *
     * @return string
     */
    public function render()
    {
        if (in_array($this->type, $this->types)) {
            $method = $this->type.'ToHtml';

            return $this->$method();
        }

        return '';
    }

    /**
     * Set view.
     *
     * @param string $view View
     */
    public function setView($view = null)
    {
        $this->view = $view;
    }

    /**
     * Personalized views.
     *
     * @param string $viewName Name of the base view
     * @param array  $params   Params
     * @param string $type     Block type
     */
    public function view($viewName, $params = [], $type = null)
    {
        if (empty($type)) {
            $type = $this->type;
        }

        $jsExternal = $this->getJsExternal();
        if (!empty($jsExternal[$this->output][$type])) {
            $this->codejs[$type] = $jsExternal[$this->output][$type];
        }

        if (!empty($this->view) && View::exists($this->view.'.'.$viewName)) {
            return view($this->view.'.'.$viewName, $params);
        } elseif (isset($this->config['view']) && View::exists($this->config['view'].'.'.$viewName)) {
            return view($this->config['view'].'.'.$viewName, $params);
        }

        return view('sirtrevorjs::html.'.$viewName, $params);
    }

    /**
     * Returns code js.
     *
     * @return array
     */
    public function getCodeJs()
    {
        return $this->codejs;
    }
    
    /**
     * Returns external js code
     * 
     * @return array
     */
    public function getJsExternal()
    {
        return [];
    }
}
