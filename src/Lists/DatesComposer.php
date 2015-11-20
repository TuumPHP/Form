<?php
namespace Tuum\Form\Lists;

use Tuum\Form\Data\Inputs;
use Tuum\Form\Dates;
use Tuum\Form\Tags\Composite;

class DatesComposer
{
    /**
     * @var Dates
     */
    private $dates;

    /**
     * @var Inputs
     */
    private $inputs;

    /**
     * definitions for composite form elements.
     *
     * @var array
     */
    public $composeDateTime = [
        'ymd' => [
            'fields' => [
                'y' => 'selYear',
                'm' => 'selMonth',
                'd' => 'selDay',
            ],
            'format' => '%1$s/%2$s/%3$s',
        ],
        'ym' => [
            'fields' => [
                'y' => 'selYear',
                'm' => 'selMonth',
            ],
            'format' => '%1$s/%2$s',
        ],
        'his' => [
            'fields' => [
                'h' => 'selHour',
                'i' => 'selMinute',
                's' => 'selSecond',
            ],
            'format' => '%1$s:%2$s:%3$s',
        ],
        'hi' => [
            'fields' => [
                'h' => 'selHour',
                'i' => 'selMinute',
            ],
            'format' => '%1$s:%2$s',
        ],
    ];

    /**
     * DatesComposer constructor.
     *
     * @param Dates $dates
     */
    public function __construct($dates)
    {
        $this->dates = $dates;
    }

    /**
     * @param Inputs $inputs
     */
    public function setInputs($inputs)
    {
        $this->inputs = $inputs;
    }

    /**
     * @param string $type
     * @param string $name
     * @param string $value
     * @param string $format
     * @return Composite
     */
    private function composeComposite($type, $name, $value, $format)
    {
        if (!$info = $this->composeDateTime[$type]) {
            throw new \BadMethodCallException;
        }
        $format = $format ?: $info['format'];
        $fields = [];
        foreach($info['fields'] as $key => $method) {
            $fields[$key] = $this->dates->$method($name);
        }
        return $this->dates->makeComposite($name, $fields, $format, $value);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $ymd_format
     * @return Composite
     */
    public function dateYMD($name, $value = null, $ymd_format = null)
    {
        return $this->composeComposite('ymd', $name, $value, $ymd_format);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $ym_format
     * @return Composite
     */
    public function dateYM($name, $value = null, $ym_format = null)
    {
        return $this->composeComposite('ym', $name, $value, $ym_format);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $hi_format
     * @return Composite
     */
    public function timeHi($name, $value = null, $hi_format = null)
    {
        return $this->composeComposite('hi', $name, $value, $hi_format);
    }

    /**
     * @param string      $name
     * @param string|null $value
     * @param string|null $his_format
     * @return Composite
     */
    public function timeHis($name, $value = null, $his_format = null)
    {
        return $this->composeComposite('his', $name, $value, $his_format);
    }

}