<?php

declare(strict_types=1);

namespace Xanpena\SVGChartBuilder;

use Xanpena\SVGChartBuilder\Svg\{
    BarChartBuilder,
    DoughnutChartBuilder,
    HorizontalBarChartBuilder,
    PieChartBuilder
};

class SVGChartBuilder
{
    const CHART_TYPE_BAR = 'bar';
    const CHART_TYPE_DOUGHNUT = 'doughnut';
    const CHART_TYPE_HORIZONTALBAR = 'horizontal-bar';
    const CHART_TYPE_PIE = 'pie';

    protected $validChartTypes = [
        self::CHART_TYPE_BAR,
        self::CHART_TYPE_DOUGHNUT,
        self::CHART_TYPE_HORIZONTALBAR,
        self::CHART_TYPE_PIE,
    ];

    protected $type;
    protected $data;

    /**
     * Constructor.
     *
     * @param string $type Type of chart to create.
     * @param array $data Data for the chart.
     * @throws \InvalidArgumentException If the type or data is invalid.
     */
    public function __construct($type, $data)
    {
        $this->validateType($type);
        $this->validateData($data);

        $this->type = $type;
        $this->data = $data;
    }

    /**
     * Create and return the SVG chart.
     *
     * @return string SVG representation of the chart.
     */
    public function create()
    {
        $chart = '';

        switch ($this->type) {
            case self::CHART_TYPE_BAR:
                $chart = (new BarChartBuilder($this->data))->makeSvg();
                break;
            case self::CHART_TYPE_DOUGHNUT:
                $chart = (new DoughnutChartBuilder($this->data))->makeSvg();
                break;
            case self::CHART_TYPE_HORIZONTALBAR:
                $chart = (new HorizontalBarChartBuilder($this->data))->makeSvg();
                break;
            case self::CHART_TYPE_PIE:
                $chart = (new PieChartBuilder($this->data))->makeSvg();
                break;
        }

        return $chart;
    }

    /**
     * Validate the chart type.
     *
     * @param string $type Type of chart to validate.
     * @throws \InvalidArgumentException If the type is not valid.
     */
    protected function validateType($type)
    {
        if (!in_array($type, $this->validChartTypes)) {
            throw new \InvalidArgumentException("Invalid chart type: $type");
        }
    }

    /**
     * Validate the chart data.
     *
     * @param array $data Data for the chart to validate.
     * @throws \InvalidArgumentException If the data is not valid.
     */
    protected function validateData($data)
    {
        if (!is_array($data) || empty($data)) {
            throw new \InvalidArgumentException("Data must be a non-empty array");
        }

        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_numeric($value)) {
                throw new \InvalidArgumentException("Each element of data must have a string label as key and a numeric value");
            }
        }
    }



}
