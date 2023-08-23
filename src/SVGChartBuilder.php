<?php

declare(strict_types=1);

namespace Xanpena\SVGChartBuilder;

use Xanpena\SVGChartBuilder\Svg\BarChartBuilder;
use Xanpena\SVGChartBuilder\Svg\HorizontalBarChartBuilder;

class SVGChartBuilder
{

    const BAR_CHART           = 'bar';
    const HORIZONTALBAR_CHART = 'horizontal-bar';
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
        $chart = '';

        switch ($type) {
            case static::BAR_CHART:
                $chart = (new BarChartBuilder($data))->makeSvg();
                break;
            case static::HORIZONTALBAR_CHART:
                $chart = (new HorizontalBarChartBuilder($data))->makeSvg();
                break;

        }
        return $chart;
    }

}


