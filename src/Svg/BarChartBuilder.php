<?php

namespace Xanpena\SVGChartBuilder\Svg;

class BarChartBuilder extends BaseChartBuilder {

    protected int $width = 400;
    protected int $height = 300;
    protected array $series = [];

    /**
     * Initialize properties.
     *
     * @return void
     */
    protected function initialize($data) {
        parent::initialize($data);
        $this->series = array_keys($this->data);
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
            ->closeSvgTag();

        return $this->svg;
    }

    /**
     * Generate the X and Y axes of the bar chart.
     *
     * @return $this
     */
    protected function drawAxis()
    {
        $this->svg .= '<line x1="50" y1="250" x2="' . ($this->width + 20) . '" y2="250" stroke="black" />';
        $this->svg .= '<line x1="50" y1="250" x2="50" y2="50" stroke="black" />';

        return $this;
    }

    /**
     * Generate the chart on SVG canvas.
     *
     * @return $this
     */
    protected function drawGraphData()
    {
        $numSeries = count($this->series);
        $availableWidth = $this->width - 100;
        $widthRatio = $availableWidth / $numSeries;
        $spaceRatio = 10;

        $baseX = 50;
        $baseY = 250;

        $counter = 0;
        $x = $baseX;

        foreach ($this->data as $data) {
            if ($counter >= count($this->colors)) {
                $counter = 0;
            }

            $proportion = $data / max($this->data);
            $barHeight = $proportion * ($baseY - 50);
            $y = $baseY - $barHeight;

            $this->svg .= '<rect x="'.$x.'" y="'.$y.'" width="'.$widthRatio.'" height="'.$barHeight.'" fill="'.$this->colors[$counter].'"/>';

            $valueX = $x + $widthRatio / 2;
            $valueY = $y + $barHeight / 2;

            $this->svg .= '<text x="'.$valueX.'" y="'.$valueY.'" font-family="Arial" font-size="14" fill="black" text-anchor="middle" dominant-baseline="middle">'.$data.'</text>';

            $x += $widthRatio + $spaceRatio;
            $counter++;
        }

        return $this;
    }

    /**
     * Generate the labels below the X axis of the chart.
     *
     * @return $this
     */
    protected function drawLabels()
    {
        $numSeries = count($this->series);
        $availableWidth = $this->width - 100;
        $widthRatio = $availableWidth / $numSeries;
        $spaceRatio = 10;

        $baseX = 50;
        $baseY = 250;

        $x = $baseX + $widthRatio / 2;
        $y = $baseY + 30;

        $rotation = -45;
        $verticalOffset = 10 * abs(sin(deg2rad($rotation)));
        $horizontalOffset = -($widthRatio / 4);

        foreach ($this->series as $key => $series) {
            if ($key >= count($this->colors)) {
                $key = 0;
            }

            $this->svg .= '<text transform="rotate('.$rotation.', '.$x.', '.$y.')" x="'.($x + $horizontalOffset).'" y="'.($y + $verticalOffset).'" font-family="Arial" font-size="14" fill="'.$this->colors[$key].'" text-anchor="middle">'.$series.'</text>';

            $x += $widthRatio + $spaceRatio;
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
            $this->svg .= '<text x="'.$x.'" y="'.$y.'" font-family="Arial" font-size="12" fill="black" text-anchor="end">'.($i * 10).'</text>';
            $y -= $ySpacing;
        }

        return $this;
    }

}
