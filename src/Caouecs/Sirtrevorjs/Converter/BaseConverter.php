<?php

declare(strict_types=1);

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs\Converter;

use Caouecs\Sirtrevorjs\Contracts\Parsable;
use Illuminate\Contracts\View\View;

/**
 * Base of converters for Sir Trevor Js.
 */
class BaseConverter
{
    /**
     * Parser instance.
     *
     * @var Parsable
     */
    protected $parser;

    /**
     * Config of Sir Trevor Js.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Type of block.
     *
     * @var string
     */
    protected $type = '';

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
    protected $data = [];

    /**
     * View.
     *
     * @var string
     */
    protected $view = '';

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
    protected $codejs = [];

    /**
     * Construct.
     *
     * @param Parsable $parser Parser instance
     * @param array    $config Config of Sir Trevor Js
     * @param array    $data   Data of element
     * @param string   $output Type of output (amp, fb, html)
     */
    public function __construct(Parsable $parser, array $config, array $data, string $output = 'html')
    {
        $this->config = $config;
        $this->data = $data['data'] ?? '';
        $this->output = $output;
        $this->parser = $parser;
        $this->type = $data['type'] ?? '';
    }

    /**
     * Render.
     */
    public function render(): string
    {
        if (in_array($this->type, $this->types)) {
            $method = $this->type.'ToHtml';

            return $this->$method();
        }

        return '';
    }

    /**
     * Set view.
     */
    public function setView(string $view = ''): void
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
    public function view(string $viewName, array $params = [], string $type = ''): string
    {
        if (empty($type)) {
            $type = $this->type;
        }

        $jsExternal = $this->getJsExternal();
        if (! empty($jsExternal[$this->output][$type])) {
            $this->codejs[$type] = $jsExternal[$this->output][$type];
        }

        if (! empty($this->view) && View::exists($this->view.'.'.$viewName)) {
            return view($this->view.'.'.$viewName, $params)->render();
        }

        if (isset($this->config['view']) && View::exists($this->config['view'].'.'.$viewName)) {
            return view($this->config['view'].'.'.$viewName, $params)->render();
        }

        return view('sirtrevorjs::html.'.$viewName, $params)->render();
    }

    /**
     * Returns code js.
     */
    public function getCodeJs(): array
    {
        return $this->codejs;
    }

    /**
     * Returns external js code.
     */
    public function getJsExternal(): array
    {
        return [];
    }
}
