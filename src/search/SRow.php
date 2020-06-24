<?php

namespace tpext\builder\search;

use tpext\builder\common\Search;
use tpext\builder\inface\Renderable;
use tpext\builder\traits\HasDom;
use tpext\builder\traits\HasRow;

class SRow extends SWrapper implements Renderable
{
    use HasDom;
    use HasRow;
    protected $where;

    /**
     * Undocumented variable
     *
     * @var Search
     */
    protected $form;

    public function __construct($name, $label = '', $colSize = 2, $where = '')
    {
        if (empty($label)) {
            $label = ucfirst($name);
        }

        $this->name = $name;
        $this->label = $label;
        $this->cloSize = $colSize;
        $this->where = $where;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Search $val
     * @return $this
     */
    public function setForm($val)
    {
        $this->form = $val;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return Search
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Undocumented function
     *
     * @param array $data
     * @return $this
     */
    public function fill($data = [])
    {
        $this->displayer->fill($data);
        return $this;
    }

    public function __call($name, $arguments)
    {
        if (static::isDisplayer($name)) {

            $class = static::$displayerMap[$name];

            return $this->createDisplayer($class, $arguments);
        }

        throw new \UnexpectedValueException('未知调用:' . $name);
    }
}
