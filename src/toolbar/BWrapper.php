<?php

namespace tpext\builder\toolbar;

use tpext\common\ExtLoader;

/**
 * Class Wapper.
 *
 * @method \tpext\builder\toolbar\LinkBtn          linkBtn($name, $label)
 * @method \tpext\builder\toolbar\ActionBtn        actionBtn($name, $label)
 * @method \tpext\builder\toolbar\DropdownBtns     dropdownBtns($items, $label)
 * @method \tpext\builder\toolbar\MultipleActions  multipleActions($items, $label)
 * @method \tpext\builder\toolbar\Actions          actions($items, $label)
 * @method \tpext\builder\toolbar\Html             html($html)
 */

class BWrapper
{
    protected static $bars = [];

    protected static $barsMap = [
        'linkBtn' => \tpext\builder\toolbar\LinkBtn::class,
        'actionBtn' => \tpext\builder\toolbar\ActionBtn::class,
        'dropdownBtns' => \tpext\builder\toolbar\DropdownBtns::class,
        'multipleActions' => \tpext\builder\toolbar\MultipleActions::class,
        'actions' => \tpext\builder\toolbar\Actions::class,
        'html' => \tpext\builder\toolbar\Html::class,
    ];

    protected static $defaultBarClass = [
        \tpext\builder\toolbar\LinkBtn::class => 'btn-xs',
        \tpext\builder\toolbar\ActionBtn::class => 'btn-xs',
        \tpext\builder\toolbar\DropdownBtns::class => 'btn-xs',
        \tpext\builder\toolbar\MultipleActions::class => 'btn-xs',
        \tpext\builder\toolbar\Actions::class => 'btn-xs',
    ];

    /**
     * Undocumented function
     *
     * @param string $name
     * @return boolean
     */
    public static function isBar($name)
    {
        if (empty(self::$bars)) {
            self::$bars = array_keys(self::$barsMap);
        }

        return in_array($name, self::$bars);
    }

    /**
     * Undocumented function
     *
     * @param string $type
     * @return string
     */
    public static function hasDefaultBarClass($type)
    {
        if (isset(self::$defaultBarClass[$type])) {
            return self::$defaultBarClass[$type];
        }

        return '';
    }

    /**
     * Undocumented function
     *
     * @param array $pair
     * @return void
     */
    public static function extend($pair)
    {
        self::$barsMap = array_merge(self::$barsMap, $pair);
    }

    /**
     * Undocumented function
     *
     * @param array $pair
     * @return void
     */
    public static function setDefaultBarClass($pair)
    {
        self::$defaultBarClass = array_merge(self::$defaultBarClass, $pair);
    }

    /**
     * 创建自身
     *
     * @param mixed $arguments
     * @return static
     */
    public static function make(...$arguments)
    {
        return self::makeBar(basename(get_called_class()), $arguments);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @param array $arguments
     * 
     * @return mixed
     */
    public static function makeBar($name, $arguments = [])
    {
        if (!is_array($arguments)) {
            $arguments = [$arguments];
        }
        
        $bar = new self::$barsMap[$name](...$arguments);

        $bar->created();

        ExtLoader::trigger('tpext_bar_created', $bar);

        return $bar;
    }
}
