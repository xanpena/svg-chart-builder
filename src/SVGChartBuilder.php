<?php

declare(strict_types=1);

namespace Xanpena\SVGChartBuilder;

use Xanpena\SVGChartBuilder\Svg\{BarChartBuilder,
    DoughnutChartBuilder,
    HorizontalBarChartBuilder,
    LineChartBuilder,
    PieChartBuilder};

class SVGChartBuilder
{
    const OPTION_COLORS = 'colors';
    const OPTION_AXIS_COLORS = 'axisColors';
    const OPTION_LABELS_COLOR = 'labelsColor';
    const OPTION_DATA_COLOR = 'dataColor';

    const OPTION_TYPES = [
        self::OPTION_COLORS,
        self::OPTION_AXIS_COLORS,
        self::OPTION_LABELS_COLOR,
        self::OPTION_DATA_COLOR
    ];

    const CHART_TYPE_BAR = 'bar';
    const CHART_TYPE_DOUGHNUT = 'doughnut';
    const CHART_TYPE_HORIZONTALBAR = 'horizontal-bar';
    const CHART_TYPE_PIE = 'pie';
    const CHART_TYPE_LINE = 'line';

    protected $validChartTypes = [
        self::CHART_TYPE_BAR,
        self::CHART_TYPE_DOUGHNUT,
        self::CHART_TYPE_HORIZONTALBAR,
        self::CHART_TYPE_PIE,
        self::CHART_TYPE_LINE,
    ];

    protected $type;
    protected $data;
    protected $options;

    /**
     * Constructor.
     *
     * @param string $type Type of chart to create.
     * @param array $data Data for the chart.
     * @throws \InvalidArgumentException If the type or data is invalid.
     */
    public function __construct($type, $data, $options = [])
    {
        $this->validateType($type);
        $this->validateData($type, $data);
        $this->validateOptions($data, $options);

        $this->type = $type;
        $this->data = $data;
        $this->options = $options;
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
                $chart = (new BarChartBuilder($this->data, $this->options))->makeSvg();
                break;
            case self::CHART_TYPE_DOUGHNUT:
                $chart = (new DoughnutChartBuilder($this->data, $this->options))->makeSvg();
                break;
            case self::CHART_TYPE_HORIZONTALBAR:
                $chart = (new HorizontalBarChartBuilder($this->data, $this->options))->makeSvg();
                break;
            case self::CHART_TYPE_PIE:
                $chart = (new PieChartBuilder($this->data, $this->options))->makeSvg();
                break;
            case self::CHART_TYPE_LINE:
                $chart = (new LineChartBuilder($this->data, $this->options))->makeSvg();
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
     * @param string $type Type of chart to validate.
     * @param array $data Data for the chart to validate.
     * @throws \InvalidArgumentException If the data is not valid.
     */
    protected function validateData($type, $data)
    {
        if (!is_array($data) || empty($data)) {
            throw new \InvalidArgumentException("Data must be a non-empty array");
        }

        switch ($type) {
            case self::CHART_TYPE_LINE:
                $this->validateDataLineGraph($data);
                break;
            default:
                $this->validateDataGenericGraph($data);
                break;
        }
    }


    protected function validateDataGenericGraph($data)
    {
        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_numeric($value)) {
                throw new \InvalidArgumentException("Each element of data must have a string label as key and a numeric value");
            }
        }
    }


    protected function validateDataLineGraph($data)
    {
        $firstSecondaryKeys = null;

        foreach ($data as $key => $value) {
            if (!is_string($key) || !is_array($value)) {
                throw new \InvalidArgumentException("Each element of data must have a string label as key and a array of data with a string labels as key and a numeric values");
            }

            $secondaryKeys = array_keys($value);
            if ($firstSecondaryKeys === null) {
                $firstSecondaryKeys = $secondaryKeys;
            } else if ($firstSecondaryKeys !== $secondaryKeys) {
                throw new \InvalidArgumentException("Secondary keys for each value in the array must be identical");
            }
        }
    }

    protected function validateOptions($data, $options)
    {
        if (empty($options) === false) {
            if (!is_array($options)) {
                throw new \InvalidArgumentException("Options must be a array");
            }

            foreach ($options as $option => $values) {
                switch ($option) {
                    case self::OPTION_COLORS:
                        if (count($data) !== count($values)) {
                            throw new \InvalidArgumentException("The $option option must have the same number of data elements");
                        }
                        break;
                    case self::OPTION_AXIS_COLORS:
                        if (array_keys($values) !== ["x", "y"]) {
                            throw new \InvalidArgumentException("The $option aaa must be an array with the keys x and y and their respective colors");
                        }
                        break;
                    default:
                        if (!is_string($values) && !is_numeric($values)) {
                            throw new \InvalidArgumentException("The $option option must be a string or a numeric");
                        }
                        break;
                }
            }
        }
    }

}
