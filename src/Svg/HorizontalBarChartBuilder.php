<?php

namespace Xanpena\SVGChartBuilder\Svg;

class HorizontalBarChartBuilder {

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
    private array $series = [];

    private string $svg = '';
    private int $height = 300;

    public function __construct()
    {
        $this->data = [
            'matematicas' => 16,
            'literatura'  => 18,
            'inglés'      => 40,
            'tecnología'  => 25,
            'musica'      => 12,
            'matematicas2' => 16,
            'literatura2'  => 18,
            'chino' => 12
        ];
        $this->series = array_keys($this->data);
    }

    public function makeSvg()
    {
        $this->openSvgTag()
            ->makeAxis()
            ->makeCanvas()
            ->makeSeries()
            ->makeLabels()
            ->closeSvgTag();

        return $this->svg;
    }

    private function makeAxis()
    {
        $this->svg .= '<line x1="100" y1="' . ($this->height - 20) . '" x2="100" y2="20" stroke="black"></line>';
        $this->svg .= '<line x1="100" y1="' . ($this->height - 20) . '" x2="' . ($this->width + 20) . '" y2="' . ($this->height - 20) . '" stroke="black"></line>';

        return $this;
    }

    private function openSvgTag()
    {
        $this->svg = '<svg width="'.($this->width + 20).'" height="'.($this->height + 20).'" xmlns="http://www.w3.org/2000/svg">';

        return $this;
    }

    private function closeSvgTag()
    {
        $this->svg .= '</svg>';

        return $this;
    }

    private function makeCanvas()
    {
        $numSeries = count($this->series);
        $heightRatio = ($this->height - 120) / $numSeries; // Ancho de las barras
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
            $barHeight = $proportion * ($this->width - 120); // Ajuste de altura
            $x = $baseX;

            $this->svg .= '<rect x="'.$x.'" y="'.$y.'" width="'.$barHeight.'" height="'.$heightRatio.'" fill="'.$this->colors[$counter].'"/>';

            $y -= $heightRatio + $spaceRatio;
            $counter++;
        }

        return $this;
    }


    private function makeLabels()
    {
        $numSeries = count($this->series);
        $heightRatio = ($this->height - 120) / $numSeries; // Ajuste de alto
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

    private function makeSeries()
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
