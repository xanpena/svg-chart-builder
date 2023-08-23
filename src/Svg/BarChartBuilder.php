<?php

namespace Xanpena\SVGChartBuilder\Svg;

class BarChartBuilder {

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
    private int $height = 300;
    private array $series = [];

    private string $svg = '';
    private int $width = 400;

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
            'inglés2'      => 40
        ];
        $this->series = array_keys($this->data);
    }

    public function makeSvg()
    {
        $this->openSvgTag()
            ->makeAxis()
            ->makeSeries()
            ->makeCanvas()
            ->makeLabels()
            ->closeSvgTag();

        return $this->svg;
    }

    private function makeAxis()
    {
        $this->svg .= '<line x1="50" y1="250" x2="' . ($this->width + 20) . '" y2="250" stroke="black" />';
        $this->svg .= '<line x1="50" y1="250" x2="50" y2="50" stroke="black" />';

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
        $widthRatio = ($this->width - 10) / $numSeries; // Ajuste de ancho
        $spaceRatio = 10;

        $baseX = 50;
        $baseY = 250;

        $counter = 0;
        $x = $baseX;

        foreach ($this->data as $key => $data) {
            if ($counter >= count($this->colors)) {
                $counter = 0;
            }

            $proportion = $data / max($this->data);
            $barHeight = $proportion * ($baseY - 50);
            $y = $baseY - $barHeight;

            $this->svg .= '<rect x="'.$x.'" y="'.$y.'" width="'.$widthRatio.'" height="'.$barHeight.'" fill="'.$this->colors[$counter].'"/>';

            $x += $widthRatio + $spaceRatio;
            $counter++;
        }

        return $this;
    }

    private function makeLabels()
    {
        $numSeries = count($this->series);
        $widthRatio = ($this->width - 100) / $numSeries; // Ajuste de ancho
        $spaceRatio = 10;

        $baseX = 50;
        $baseY = 250;

        $x = $baseX + $widthRatio / 2;
        $y = $baseY + 30;

        $rotation = -45; // Grados de inclinación
        $verticalOffset = 10 * abs(sin(deg2rad($rotation))); // Desplazamiento vertical
        $horizontalOffset = -($widthRatio / 4); // Desplazamiento horizontal

        foreach ($this->series as $key => $series) {
            if ($key >= count($this->colors)) {
                $key = 0;
            }

            // Aplicamos la rotación y los desplazamientos a la etiqueta
            $this->svg .= '<text transform="rotate('.$rotation.', '.$x.', '.$y.')" x="'.($x + $horizontalOffset).'" y="'.($y + $verticalOffset).'" font-family="Arial" font-size="14" fill="'.$this->colors[$key].'" text-anchor="middle">'.$series.'</text>';

            $x += $widthRatio + $spaceRatio;
        }

        return $this;
    }

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
