<?php

namespace Xanpena\SVGChartBuilder\Svg;

class LineChartBuilder {

    private $colors = [
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
    private array $data = [];
    private int $height = 500;
    private array $series = [];

    private string $svg = '';
    private int $width = 400;

    public function __construct($data)
    {
        $this->data = $data;
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
            ->makeAxis()
            ->makeSeries()
            ->makeLinesWithPoints()
            ->makeLabels()
            ->makeCirclesWithText()
            ->closeSvgTag();

        return $this->svg;
    }

    /**
     * Generate the X and Y axes of the bar chart.
     *
     * @return $this
     */
    private function makeAxis()
    {
        $this->svg .= '<line x1="50" y1="250" x2="' . ($this->width + 20) . '" y2="250" stroke="black" />';
        $this->svg .= '<line x1="50" y1="250" x2="50" y2="50" stroke="black" />';

        return $this;
    }

    /**
     * Open the SVG tag with the specified width and height.
     *
     * @return $this
     */
    private function openSvgTag()
    {
        $this->svg = '<svg width="'.($this->width + 20).'" height="'.($this->height + 20).'" xmlns="http://www.w3.org/2000/svg">';

        return $this;
    }

    /**
     * Close the SVG tag.
     *
     * @return $this
     */
    private function closeSvgTag()
    {
        $this->svg .= '</svg>';

        return $this;
    }

    /**
     * Generate the chart on SVG canvas.
     *
     * @return $this
     */
    private function makeLinesWithPoints()
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
    private function getMaxValue() {
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
    private function makeLabels()
    {
        $availableWidth = $this->width - 100;

        $baseX = 32;
        $baseY = 260;

        $rotation = -45;
        $verticalOffset = (10 * abs(sin(deg2rad($rotation)))) + 30;

        foreach ($this->series as $index => $series) {
            $proportion = $index / (count($this->series) - 1);
            $labelX = $baseX + $proportion * $availableWidth;

            $this->svg .= '<text transform="rotate('.$rotation.', '.$labelX.', '.$baseY.')" x="'.$labelX.'" y="'.($baseY + $verticalOffset).'" font-family="Arial" font-size="14" text-anchor="middle">'.$series.'</text>';
        }

        return $this;
    }


    private function makeCirclesWithText()
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
    private function makeSeries()
    {
        $baseX = 40;
        $baseY = 250;
        $ySpacing = ($baseY - 50) / 10;

        $x = $baseX - 10;
        $y = $baseY;

        for ($i = 0; $i <= 10; $i++) {
            $this->svg .= '<text x="'.$x.'" y="'.$y.'" font-family="Arial" font-size="12" fill="black" text-anchor="end">'.($i * 10).'</text>';
            $y -= $ySpacing;
        }

        return $this;
    }

}
