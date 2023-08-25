<?php

namespace Xanpena\SVGChartBuilder\Svg;

class LineChartBuilder extends BaseChartBuilder {

    protected int $width = 400;
    protected int $height = 500;
    private array $series = [];
    protected array $axisColors = [];

    /**
     * Initialize properties.
     *
     */
    protected function initialize($data) {
        $this->series = array_keys($this->data[(key($this->data))]);
    }

    /**
     * Generate the SVG representation of the chart.
     *
     * @return string The SVG representation of the chart.
     */
    public function makeSvg()
    {
        $this->openSvgTag()
            ->drawAxis()
            ->drawSeries()
            ->drawGraphData()
            ->drawLabels()
            ->drawCirclesWithText()
            ->closeSvgTag();

        return $this->svg;
    }

    /**
     * Generate the X and Y axes of the bar chart.
     *
     * @return $this
     */
    private function drawAxis()
    {
        $this->svg .= '<line x1="50" y1="250" x2="' . ($this->width + 20) . '" y2="250" stroke="'. $this->getAxisColor('x') .'" />';
        $this->svg .= '<line x1="50" y1="250" x2="50" y2="50" stroke="'. $this->getAxisColor('y') .'" />';

        return $this;
    }


    /**
     * Generate the chart on SVG canvas.
     *
     * @return $this
     */
    protected function drawGraphData()
    {
        $maxValue = $this->getMaxValue();
        $availableWidth = $this->width - 100;
        $widthRatio = $availableWidth / (count($this->series) - 1);

        $baseX = 50;
        $baseY = 250;

        $counter = 0;

        foreach ($this->data as $labels) {
            $x = $baseX;
            $previousY = null;

            if ($counter >= count($this->colors)) {
                $counter = 0;
            }

            foreach ($labels as $label => $data) {
                $isFirst = ($label === array_key_first($labels));
                $proportion = $data / $maxValue;
                $y = $baseY - $proportion * ($baseY - 50);

                if ($previousY !== null) {
                    $this->svg .= '<line x1="' . $previousX . '" y1="' . $previousY . '" x2="' . $x . '" y2="' . $y . '" stroke="'.$this->colors[$counter].'" stroke-width="3"/>';
                }

                $previousX = $x;
                $previousY = $y;

                $this->svg .= '<circle cx="' . $x . '" cy="' . $y . '" r="4" fill="'.$this->colors[$counter].'" />';

                $this->svg .= '<text x="' . $x + (($isFirst) ? 8 : 0) . '" y="' . ($y - 10) . '"
                font-family="Arial"
                font-size="12"
                font-weight="bold"
                text-anchor="middle"
                fill="'.$this->colors[$counter].'">' . $data . '</text>';

                $x += $widthRatio;
            }

            $counter++;
        }

        return $this;
    }

    /**
     * Get Max Value
     *
     * @return int $maxValue
     */
    protected function getMaxValue() {
        $maxValue = 0;

        foreach ($this->data as $labels) {
            foreach ($labels as $data) {
                if ($maxValue === null || $data > $maxValue) {
                    $maxValue = $data;
                }
            }
        }

        return $maxValue;
    }

    /**
     * Generate the labels below the X axis of the chart.
     *
     * @return $this
     */
    protected function drawLabels()
    {
        $availableWidth = $this->width - 100;

        $baseX = 32;
        $baseY = 260;

        $rotation = -45;
        $verticalOffset = (10 * abs(sin(deg2rad($rotation)))) + 30;

        foreach ($this->series as $index => $series) {
            $proportion = $index / (count($this->series) - 1);
            $labelX = $baseX + $proportion * $availableWidth;

            $this->svg .= '<text transform="rotate('.$rotation.', '.$labelX.', '.$baseY.')" x="'.$labelX.'" y="'.($baseY + $verticalOffset).'" font-family="Arial" font-size="14" text-anchor="middle" fill="'. $this->labelsColor .'">'.$series.'</text>';
        }

        return $this;
    }


    protected function drawCirclesWithText()
    {
        $labels = array_keys($this->data);
        $availableWidth = $this->width - 100;

        $baseX = 50;
        $baseY = 250;

        foreach ($labels as $index => $label) {
            $proportion = $index / (count($labels) - 1);
            $x = $baseX + $proportion * $availableWidth;

            $circleY = $baseY + 90;
            $circleColor = $this->colors[$index];

            $this->svg .= '<circle cx="' . $x . '" cy="' . $circleY . '" r="5" fill="' . $circleColor . '" />';
            $this->svg .= '<text x="' . $x . '" y="' . ($circleY + 20) . '" font-family="Arial" font-size="12" text-anchor="middle" fill="' . $circleColor . '">' . $label . '</text>';
        }

        return $this;
    }

    /**
     * Generate the Y axis labels.
     *
     * @return $this
     */
    protected function drawSeries()
    {
        $baseX = 40;
        $baseY = 250;
        $ySpacing = ($baseY - 50) / 10;

        $x = $baseX - 10;
        $y = $baseY;

        for ($i = 0; $i <= 10; $i++) {
            $this->svg .= '<text x="'.$x.'" y="'.$y.'" font-family="Arial" font-size="12" fill="'. $this->labelsColor .'" text-anchor="end">'.($i * 10).'</text>';
            $y -= $ySpacing;
        }

        return $this;
    }

    protected function getAxisColor($axis)
    {
        if (empty($this->axisColors) === false && array_key_exists($axis, $this->axisColors)) {
            return $this->axisColors[$axis];
        }

        return '#000000';
    }

}
