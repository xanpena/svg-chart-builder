# SVGChartBuilder

SVGChartBuilder is a PHP library that allows you to generate SVG-based charts for use in your backend applications.

### Requirements

PHP 8.0 or later

## Installation

You can install SVGChartBuilder via Composer:

To install using Composer, run the following command in your terminal:

```bash
    composer require xanpena/svg-chart-builder
```

## Usage

SVGChartBuilder provides several types of charts that you can create:

### Example

To create a bar chart, use the following code:

```php
use Xanpena\SVGChartBuilder\SVGChartBuilder;

$data = [
    'math' => 16,
    'literature' => 18,
    'english' => 40,
    // ... other data ...
];
$chartBuilder = new SVGChartBuilder(SVGChartBuilder::CHART_TYPE_BAR, $data);
$svg = $chartBuilder->create();
echo $svg;
```

### Chart Types
SVGChartBuilder supports the following chart types:

SVGChartBuilder::BAR_CHART: Bar chart<br>
SVGChartBuilder::DOUGHNUT_CHART: Doughnut chart<br>
SVGChartBuilder::HORIZONTALBAR_CHART: Horizontal bar chart<br>
SVGChartBuilder::PIE_CHART: Pie chart<br>


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please using the issue tracker.

## Credits

- [Xan Pena](https://github.com/xanpena)
- [Francisco Prieto](https://github.com/fjpj2310)
