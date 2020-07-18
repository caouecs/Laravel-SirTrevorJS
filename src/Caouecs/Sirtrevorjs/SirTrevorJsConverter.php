<?php

/**
 * Laravel-SirTrevorJs.
 *
 * @see https://github.com/caouecs/Laravel-SirTrevorJs
 */

namespace Caouecs\Sirtrevorjs;

use Caouecs\Sirtrevorjs\Contracts\ParserInterface;

/**
 * Class Converter.
 *
 * A Sir Trevor to HTML conversion helper for PHP
 * inspired by work of Wouter Sioen <info@woutersioen.be>
 */
class SirTrevorJsConverter
{
    /**
     * Configuration.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Parser.
     *
     * @var ParserInterface
     */
    protected $parser;

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
     * @var string
     */
    protected $codeJs;

    /**
     * Valid blocks with converter.
     *
     * @var array
     */
    protected $blocks = [
        'blockquote' => 'Text',
        'embedly' => 'Embed',
        'facebook' => 'Social',
        'gettyimages' => 'Image',
        'heading' => 'Text',
        'iframe' => 'Embed',
        'image' => 'Image',
        'issuu' => 'Presentation',
        'list' => 'Text',
        'markdown' => 'Text',
        'pinterest' => 'Image',
        'quote' => 'Text',
        'sketchfab' => 'Modelisation',
        'slideshare' => 'Presentation',
        'soundcloud' => 'Sound',
        'spotify' => 'Sound',
        'text' => 'Text',
        'tweet' => 'Social',
        'video' => 'Video',
    ];

    /**
     * Custom blocks.
     *
     * @var array
     */
    protected $customBlocks = [];

    /**
     * Construct.
     *
     * @param ParserInterface $parser
     * @param array           $config
     * @param string          $view   View
     */
    public function __construct(ParserInterface $parser, array $config, string $view = '')
    {
        $this->config = $config;
        $this->parser = $parser;
        $this->view = $view;
    }

    /**
     * Set view.
     *
     * @param string $view
     */
    public function setView(string $view): void
    {
        $this->view = $view;
    }

    /**
     * Converts the outputted json from Sir Trevor to Html.
     *
     * @param string $json
     */
    public function toHtml(string $json): string
    {
        if (empty($this->view)) {
            $this->view = 'sirtrevorjs::html';
        }

        $this->output = 'html';

        return $this->convert($json);
    }

    /**
     * Converts the outputted json from Sir Trevor to Amp.
     *
     * @param string $json
     */
    public function toAmp(string $json): string
    {
        if (empty($this->view)) {
            $this->view = 'sirtrevorjs::amp';
        }

        $this->output = 'amp';

        return $this->convert($json, false);
    }

    /**
     * Converts the outputted json from Sir Trevor to Facebook Articles.
     *
     * @param string $json
     */
    public function toFb(string $json): string
    {
        if (empty($this->view)) {
            $this->view = 'sirtrevorjs::fb';
        }

        $this->output = 'fb';

        return $this->convert($json);
    }

    /**
     * Convert the outputted json from Sir Trevor.
     *
     * @param string $json
     * @param bool   $externalJs
     */
    public function convert(string $json, bool $externalJs = true): string
    {
        // convert the json to an associative array
        $input = json_decode($json, true);
        $text = '';
        $codejs = [];

        if (empty($this->view)) {
            $this->view = 'sirtrevorjs::html';
        }

        if (is_array($input)) {
            // blocks
            $listBlocks = $this->getBlocks();

            // loop trough the data blocks
            foreach ($input['data'] as $block) {
                // no data, problem
                if (! isset($block['data']) || ! array_key_exists($block['type'], $listBlocks)) {
                    break;
                }

                $class = $listBlocks[$block['type']];
                $converter = new $class($this->parser, $this->config, $block, $this->output);
                $converter->setView($this->view);
                $text .= $converter->render();
                $codejsClass = $converter->getCodeJs();

                if (is_array($codejsClass)) {
                    $codejs = array_merge($codejs, $codejsClass);
                }
            }

            // code js
            if ($externalJs && is_array($codejs)) {
                $text .= implode($codejs);
            }

            $this->codeJs = implode($codejs);
        }

        return $text;
    }

    /**
     * Return base blocks and custom blocks with good classes.
     */
    protected function getBlocks(): array
    {
        $blocks = [];

        foreach ($this->blocks as $key => $value) {
            $blocks[$key] = 'Caouecs\\Sirtrevorjs\\Converter\\'.$value.'Converter';
        }

        if (! empty($this->customBlocks)) {
            $blocks = array_merge($blocks, $this->customBlocks);
        }

        if (isset($this->config['customBlocks']) && ! empty($this->config['customBlocks'])) {
            $blocks = array_merge($blocks, $this->config['customBlocks']);
        }

        return $blocks;
    }

    /**
     * Returns code js.
     */
    public function getCodeJs(): string
    {
        return $this->codeJs;
    }
}
