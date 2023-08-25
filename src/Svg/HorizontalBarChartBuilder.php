<?php

namespace Xanpena\SVGChartBuilder\Svg;

class HorizontalBarChartBuilder extends BaseChartBuilder {

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
            ->makeAxis()
            ->generateSvg()
            ->makeSeries()
            ->drawLabels()
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
        $this->svg .= '<line x1="100" y1="' . ($this->height - 20) . '" x2="100" y2="20" stroke="black"></line>';
        $this->svg .= '<line x1="100" y1="' . ($this->height - 20) . '" x2="' . ($this->width + 20) . '" y2="' . ($this->height - 20) . '" stroke="black"></line>';

        return $this;
    }


    /**
     * Generate the chart on SVG canvas.
     *
     * @return $this
     */
    protected function generateSvg()
    {
        $numSeries = count($this->series);
        $heightRatio = ($this->height - 120) / $numSeries;
        $spaceRatio = 10;

        $baseX = 100;
        $baseY = $this->height - 43;

        $counter = 0;
        $y = $baseY;

        foreach ($this->data as $key => $data) {
            if ($counter >= count($this->colors)) {
                $counter = 0;
            }

            $proportion = $data / max($this->data);
            $barHeight = $proportion * ($this->width - 120);
            $x = $baseX;

            $this->svg .= '<rect x="'.$x.'" y="'.$y.'" width="'.$barHeight.'" height="'.$heightRatio.'" fill="'.$this->colors[$counter].'"/>';

            $y -= $heightRatio + $spaceRatio;
            $counter++;
        }

        return $this;
    }

    /**
     * Generate the labels below the Y axis of the bar chart.
     *
     * @return $this
     */
    protected function drawLabels()
    {
        $numSeries = count($this->series);
        $heightRatio = ($this->height - 120) / $numSeries;
        $spaceRatio = 10;

        $baseX = 95;
        $baseY = $this->height - 20;

        $x = $baseX - 5;
        $y = $baseY - $heightRatio / 2;

        foreach ($this->series as $key => $series) {
            if ($key >= count($this->colors)) {
                $key = 0;
            }

            $this->svg .= '<text x="'.$x.'" y="'.$y.'" font-family="Arial" font-size="14" fill="'.$this->colors[$key].'" text-anchor="end" dominant-baseline="middle">'.$series.'</text>';

            $y -= $heightRatio + $spaceRatio;
        }

        return $this;
    }

    /**
     * Generate the X axis labels.
     *
     * @return $this
     */
    protected function makeSeries()
    {
        $baseX = 95;
        $baseY = $this->height - 20;
        $xSpacing = ($this->width - 120) / 10;

        $x = $baseX;
        $y = $baseY + 20;

        for ($i = 0; $i <= 10; $i++) {
            $this->svg .= '<text x="'.$x.'" y="'.$y.'" font-family="Arial" font-size="12" fill="black" text-anchor="middle" dominant-baseline="text-before-edge">'.($i * 10).'</text>';
            $x += $xSpacing;
        }

        return $this;
    }

}
