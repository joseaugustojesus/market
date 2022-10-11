<?php

namespace app\support;

use Exception;

class ApexCharts
{
    private $name = '';
    private $data = [];
    private $categories = [];
    private $type;
    private $labels = [];
    private $colors = [];
    private $height = '300';
    private $width = '380';


    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function setData(array $data)
    {
        if (in_array($this->type, ['pie', 'donut'])) {
            if (is_array($data[0])) {
                throw new Exception('For the pizza type, an array with only the values to be displayed is needed', 1);
            }
        } else {
            if (!is_array($data[0])) {
                throw new Exception("It is necessary to inform an array with at least 1 item being another array with indexes name and data.", 1);
            }
        }
        $this->data = $data;
    }

    public function setCategories(array $categories)
    {
        $this->categories = $categories;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }


    public function getType()
    {
        return $this->type;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getName()
    {
        return $this->name;
    }


    public function getLabels()
    {
        return $this->labels;
    }

    public function setLabels(array $labels)
    {
        $this->labels = $labels;

        return $this;
    }


    public function getColors()
    {
        return $this->colors;
    }

    public function setColors(array $colors)
    {
        $this->colors = $colors;

        return $this;
    }


    public function getHeight()
    {
        return $this->height;
    }


    public function setHeight(string $height)
    {
        $this->height = $height;

        return $this;
    }


    public function getWidth()
    {
        return $this->width;
    }

    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }




    public function render()
    {
        /**
         * if type like line, bar or area, access this if;
         */
        if (in_array($this->type, ['line', 'bar', 'area'])) {

            $elementId = $this->name;
            $data = $this->data;

            foreach ($this->categories as $index => $category) {
                $this->categories[$index] = "'{$category}'";
            }
            $categories = implode(', ', $this->categories);

            $nameAndData = '';
            foreach ($data as $key => $value) {
                [$name, $dataValues] = array_values($value);
                $dataValues = implode(', ', $dataValues);
                $nameAndData .= "{
                name: '{$name}',
                data: [$dataValues]
            },";
            }

            $colors = '';
            if ($this->colors) {
                foreach ($this->colors as $key => $value) {
                    $colors .= "else if (seriesIndex === {$key}) { return '{$value}'; } ";
                }

                $colors = <<<EOD
                ,
                colors: [
                    function ({ value, seriesIndex, dataPointIndex, w }) {
                        if(0 === 1){}
                        $colors
                    }
                ]
                EOD;
            }



            $script = <<<EOD
                <script>
                var options = {
                    chart: {
                        type: '{$this->type}',
                        height: {$this->height}
                    },
                   
                    series: [{$nameAndData}],
                    xaxis: {
                        categories: [$categories]
                    }
                    $colors
                };
                var {$elementId} = new ApexCharts(document.querySelector("#{$elementId}"), options);
                {$elementId}.render();
                </script>
            EOD;
        } else if (in_array($this->type, ['pie', 'donut'])) {

            if (!$this->data) throw new Exception("To generate the chart {$this->name} it is necessary to inform the data", 1);

            $data = implode(', ', $this->data);

            $labels = [];
            foreach ($this->labels as $index => $value) {
                $labels[$index] = "'{$value}'";
            }
            $labels = implode(', ', $labels);


            $colors = '';
            if ($this->colors) {
                foreach ($this->colors as $key => $value) {
                    $colors .= "else if (seriesIndex === {$key}) { return '{$value}'; } ";
                }

                $colors = <<<EOD
                ,
                colors: [
                    function ({ value, seriesIndex, dataPointIndex, w}) {
                        if(0 === 1){}
                        $colors
                    }
                ]
                EOD;
            }



            $script = <<<EOD
                <script>
                var options = {
                    series: [{$data}],
                    chart: {
                      width: {$this->width},
                      type: '{$this->type}',
                    },
                    legend: {
                        position: 'bottom'
                    },
                    labels: [{$labels}]
                    $colors
                  };
                  
                  var {$this->name} = new ApexCharts(document.querySelector("#{$this->name}"), options);
                  {$this->name}.render();                 
                </script>
            EOD;
        }
        return $script;
    }
}
