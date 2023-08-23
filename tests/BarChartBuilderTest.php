<?php

namespace Xanpena\SVGChartBuilder\Tests\SVGChartBuilder;

use PHPUnit\Framework\TestCase;
use Xanpena\SVGChartBuilder\SVGChartBuilder;

class BarChartBuilderTest extends TestCase
{
    public function testCreateBarChart()
    {
        $chartBuilder = new SVGChartBuilder();
        $data = [
            'matematicas' => 16,
            'literatura'  => 18,
            'inglés'      => 40,
            // ... más datos de prueba ...
        ];

        $chart = $chartBuilder->create(SVGChartBuilder::BAR_CHART, $data);

        // Agrega aquí aserciones para verificar si el resultado es el esperado
        // por ejemplo, verifica si el SVG generado contiene las etiquetas correctas
        // o si se generó correctamente el gráfico.

        $this->assertNotEmpty($chart); // Ejemplo de aserción básica
    }
}
