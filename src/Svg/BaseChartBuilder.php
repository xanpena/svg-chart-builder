<?php

namespace Xanpena\SVGChartBuilder\Svg;

abstract class BaseChartBuilder {

    protected array $colors = [
        '#2196F3',
        '#4CAF50',
        '#F44336',
        '#FFC107',
        '#FF9800',
        '#9C27B0',
        '#E91E63',
        '#9E9E9E',
        '#00BCD4',
        '#CDDC39',
    ];

    protected string $svg = '';
    protected array $data = [];
    protected int $width;
    protected int $height;


    public function __construct($data)
    {
        $this->initialize($data);
    }

    /**
     * Generate the SVG representation of the chart.
     *
     * @return string The SVG representation of the chart.
     */
    abstract protected function makeSvg();

    /**
     * Generate the chart on SVG canvas.
     *
     * @return $this
     */
    abstract protected function drawGraphData();

    /**
     * Generate the labels of the chart.
     *
     * @return $this
     */
    abstract protected function drawLabels();


    /**
     * Initialize properties.
     *
     * @return void
     */
    protected function initialize($data) {
        $this->data = $data;
    }


    /**
     * Open the SVG tag with the specified width and height.
     *
     * @return $this
     */
    protected function openSvgTag()
    {
        $this->svg = '<svg width="'.($this->width + 20).'" height="'.($this->height + 20).'" xmlns="http://www.w3.org/2000/svg">';

        return $this;
    }

    /**
     * Close the SVG tag.
     *
     * @return $this
     */
    protected function closeSvgTag()
    {
        $this->svg .= '</svg>';

        return $this;
    }

}
