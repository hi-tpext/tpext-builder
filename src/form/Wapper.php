<?php

namespace tpext\builder\form;

/**
 * Class Wapper.
 *
 * @method \tpext\builder\displayer\Text           text($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Checkbox       checkbox($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Radio          radio($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Button         button($type, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Select         select($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\MultipleSelect multipleSelect($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Textarea       textarea($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Hidden         hidden($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Id             id($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Ip             ip($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Url            url($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Color          color($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Email          email($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Mobile         mobile($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Slider         slider($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\File           file($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Image          image($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Date           date($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Datetime       datetime($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Time           time($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Year           year($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Month          month($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\DateRange      dateRange($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\DateTimeRange  datetimeRange($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\TimeRange      timeRange($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Number         number($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Currency       currency($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\SwitchField    switch($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Display        display($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Rate           rate($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Divider        divider($text, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Password       password($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Decimal        decimal($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Html           html($html, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Raw            raw($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Tags           tags($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\Icon           icon($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\MultipleImage  multipleImage($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 * @method \tpext\builder\displayer\MultipleFile   multipleFile($name, $label = '', $cloSize = 12, $colClass = '', $colAttr = '')
 */

class Wapper
{
    protected static $displayers = [];

    protected static $displayerMap = [
        'text' => \tpext\builder\displayer\Text::class,
        'textarea' => \tpext\builder\displayer\Textarea::class,
        'html' => \tpext\builder\displayer\Html::class,
        'divider' => \tpext\builder\displayer\Divider::class,
        'raw' => \tpext\builder\displayer\Raw::class,
        'checkbox' => \tpext\builder\displayer\Checkbox::class,
        'radio' => \tpext\builder\displayer\Radio::class,
        'button' => \tpext\builder\displayer\Button::class,
        'select' => \tpext\builder\displayer\Select::class,
        'multipleSelect' => \tpext\builder\displayer\MultipleSelect::class,
    ];

    protected static $defaultFieldClass = [];

    public static function isDisplayer($name)
    {
        if (empty(static::$displayers)) {
            static::$displayers = array_keys(static::$displayerMap);
        }

        return in_array($name, static::$displayers);
    }

    public static function hasDefaultFieldClass($type)
    {
        if (isset(static::$defaultFieldClass[$type])) {
            return static::$defaultFieldClass[$type];
        }

        return '';
    }

    public static function extend($pair)
    {
        static::$displayerMap = array_merge(static::$displayerMap, $pair);
    }

    public static function setdefaultFieldClass($pair)
    {
        static::$defaultFieldClass = array_merge(static::$defaultFieldClass, $pair);
    }
}
