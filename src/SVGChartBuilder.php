<?php

declare(strict_types=1);

namespace Xanpena\SVGChartBuilder;

use Xanpena\SVGChartBuilder\Svg\ChartBuilder;

class SVGChartBuilder
{

    /*
    |--------------------------------------------------------------------------
    | SVGChartBuilder
    |--------------------------------------------------------------------------
    |
    | This is the main class of the SVGChartBuilder that will allow you to
    | generate pretty charts from backend.
    |
    */

    public function __construct()
    {
    }

    public function create($type, $data)
    {
        return (new ChartBuilder($type, $data))->makeSvg();
    }

}


