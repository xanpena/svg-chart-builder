# SVGChartBuilder

SVGChartBuilder is a PHP library that allows you to generate SVG-based charts for use in your backend applications.

## Installation

You can install SVGChartBuilder via Composer:

To install using Composer, run the following command in your terminal:

```bash
    composer require xanpena/svg-chart-builder
```

## Examples

Here are some examples of charts generated using SVG Chart Builder:

### Bar Chart

![Bar Chart](/examples/bar-chart.svg)

### Doughnut Chart

![Doughnut Chart](/examples/doughnut-chart.svg)

### Horizontal Bar Chart

![Horizontal Bar Chart](/examples/horizontal-bar-chart.svg)

### Pie Chart

![Pie Chart](/examples/pie-chart.svg)


## Usage

SVGChartBuilder provides several types of charts that you can create:

### Example

To create a bar chart, use the following code:

```php
use Xanpena\SVGChartBuilder\SVGChartBuilder;

$chartBuilder = new SVGChartBuilder();
$data = [
    'math' => 16,
    'literature' => 18,
    'english' => 40,
    // ... other data ...
];

$svg = $chartBuilder->create(SVGChartBuilder::BAR_CHART, $data);
echo $svg;
```

### Chart Types
SVGChartBuilder supports the following chart types:

SVGChartBuilder::BAR_CHART: Bar chart
SVGChartBuilder::DOUGHNUT_CHART: Doughnut chart
SVGChartBuilder::HORIZONTALBAR_CHART: Horizontal bar chart
SVGChartBuilder::PIE_CHART: Pie chart


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please using the issue tracker.

## Credits

- [Xan Pena](https://github.com/xanpena)
