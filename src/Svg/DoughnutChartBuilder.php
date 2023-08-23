<?php

namespace Xanpena\SVGChartBuilder\Svg;

class DoughnutChartBuilder {

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
    private int $width = 400;
    private int $height = 400;
    private int $innerRadius = 100;

    private string $svg = '';

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Generate the SVG representation of the chart.
     *
     * @return string The SVG representation of the chart.
     */
    public function makeSvg()
    {
        $this->openSvgTag()
            ->drawSlices()
            ->drawLabels()
            ->closeSvgTag();

        return $this->svg;
    }

    /**
     * Open the SVG tag with the specified width and height.
     *
     * @return $this
     */
    private function openSvgTag()
    {
        $this->svg = '<svg width="'.($this->width).'" height="'.($this->height).'" xmlns="http://www.w3.org/2000/svg">';

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
     * Draw the slices of the pie chart based on the data.
     *
     * @return $this
     */
    private function drawSlices()
    {
        $totalValue = array_sum($this->data);
        $startAngle = 0;
        $counter = 0;

        foreach ($this->data as $key => $value) {
            if ($value <= 0) {
                continue;
            }

            if ($counter >= count($this->colors)) {
                $counter = 0;
            }

            $proportion = $value / $totalValue;
            $endAngle = $startAngle + ($proportion * 360);

            $startX = $this->width / 2;
            $startY = $this->height / 2;

            $endX1 = $startX + cos(deg2rad($startAngle)) * ($this->width / 2);
            $endY1 = $startY + sin(deg2rad($startAngle)) * ($this->height / 2);

            $endX2 = $startX + cos(deg2rad($endAngle)) * ($this->width / 2);
            $endY2 = $startY + sin(deg2rad($endAngle)) * ($this->height / 2);

            $largeArcFlag = $proportion > 0.5 ? 1 : 0;

            $this->svg .= '<path d="M'.$startX.','.$startY.' L'.$endX1.','.$endY1.' A'.($this->width / 2).','.($this->height / 2).' 0 '.$largeArcFlag.',1 '.$endX2.','.$endY2.' Z" fill="'.$this->colors[$counter].'"/>';

            $startAngle = $endAngle;
            $counter++;
        }

        return $this;
    }

    /**
     * Draw the labels for each slice on the chart.
     *
     * @return $this
     */
    private function drawLabels()
    {
        $totalValue = array_sum($this->data);
        $startAngle = 0;

        foreach ($this->data as $key => $value) {
            if ($value <= 0) {
                continue;
            }

            $proportion = $value / $totalValue;
            $endAngle = $startAngle + ($proportion * 360);

            $midAngle = $startAngle + ($endAngle - $startAngle) / 2;

            $labelX = $this->width / 2 + cos(deg2rad($midAngle)) * ($this->innerRadius + ($this->width / 4)) * 0.8;
            $labelY = $this->height / 2 + sin(deg2rad($midAngle)) * ($this->innerRadius + ($this->height / 4)) * 0.8;

            $this->svg .= '<text x="'.$labelX.'" y="'.$labelY.'" font-family="Arial" font-size="14" fill="black" text-anchor="middle" dominant-baseline="middle">'.$key.' ('.$value.')</text>';

            $startAngle = $endAngle;
        }

        return $this;
    }
}
