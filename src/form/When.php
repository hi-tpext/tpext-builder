<?php

namespace tpext\builder\form;

use tpext\builder\displayer;
use tpext\builder\common\Form;
use tpext\builder\common\Search;

class When
{
    /**
     * Undocumented variable
     *
     * @var displayer\Field
     */
    protected $watchFor = null;

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $cases = '';

    /**
     * Undocumented variable
     *
     * @var array
     */
    protected $fields = [];

    /**
     * 
     * @var bool|null
     */
    protected $matchCase = null;

    /**
     * Undocumented variable
     *
     * @var Form|Search
     */
    protected $form;

    /**
     * Undocumented function
     *
     * @param displayer\Field $watchFor
     * @param string|int|array $cases
     * @return $this
     */
    public function watch($watchFor, $cases)
    {
        $this->watchFor = $watchFor;
        if (!is_array($cases)) {
            $cases = [(string)$cases];
        }
        $this->cases = $cases;
        //
        return $this;
    }

    /**
     * 判断是否匹配
     * @return bool
     */
    public function judgeMatchCase()
    {
        if (!is_null($this->matchCase)) {
            return $this->matchCase;
        }

        $watchForValue = $this->watchFor->renderValue();

        $matchCase = false;

        if ($this->watchFor instanceof displayer\Checkbox || $this->watchFor instanceof displayer\Transfer || $this->watchFor instanceof displayer\MultipleSelect) {

            $watchForValueArr = explode(',', trim($watchForValue, ','));

            foreach ($this->cases as $cs) {

                $csArr = explode('+', $cs);

                if (count($watchForValueArr) !== count($csArr)) {
                    continue;
                }

                $m = 0;

                foreach ($csArr as $ca) {

                    if (in_array(trim($ca), $watchForValueArr)) {
                        $m += 1;
                    }
                }

                if ($m > 0 && $m == count($watchForValueArr)) {
                    $matchCase = true;
                    break;
                }
            }
        } else // Radio / Select
        {
            $matchCase = in_array($watchForValue, $this->cases);
        }

        $this->matchCase = $matchCase;

        return $this->matchCase;
    }

    /**
     * Undocumented function
     *
     * @param displayer\Field $field
     * @return $this
     */
    public function toggle($field)
    {
        $that = $this;
        //防止不同case中有重复字段的一些问题，因为trigger('change')调用时机，js处理重name/id有局限。
        $key = preg_replace('/[^\w\-]/', '-', $that->watchFor->getName()) . md5(json_encode($that->cases));
        $this->watchFor->rendering(function () use ($field, $that, $key) {
            $matchCase = $that->judgeMatchCase();
            if ($field instanceof displayer\Fields) {
                $field->extKey('-watch-' . $key) //防止id重复
                    ->getWrapper()->addClass($matchCase ? 'match-case' : 'hidden');
                $rows = $field->getContent()->getRows();
                $subFields = null;
                foreach ($rows as $row) {
                    $subFields = $row->getDisplayer();
                    if ($subFields instanceof displayer\Fields) {
                        continue;
                    }
                    $subFields->extKey('-watch-' . $key) //防止id重复
                        ->addAttr('data-name="' . $subFields->getName() . ($subFields->isArrayValue() ? '[]' : '') . '"')
                        ->extNameKey('_' . $key); //防止name重复。真实name放在[data-name]中，case选中时替换到name属性中
                }
            } else {
                $field->extKey('-watch-' . $key) //防止id重复
                    ->addAttr('data-name="' . $field->getName() . ($field->isArrayValue() ? '[]' : '') . '"')
                    ->extNameKey('_' . $key) //防止name重复。真实name放在[data-name]中，case选中时替换到name属性中
                    ->getWrapper()->addClass($matchCase ? 'match-case' : 'hidden');
            }
        });

        $this->fields[] = $field;
        //
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Form|Search $val
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
     * @return Form|Search
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Undocumented function
     *
     * @return string|int|array
     */
    public function getCases()
    {
        return $this->cases;
    }

    /**
     * Undocumented function
     *
     * @param string $key
     * @return $this
     */
    public function setWrapperClass($key)
    {
        foreach ($this->fields as $field) {

            $field->getWrapper()->addClass($key);
        }

        return $this;
    }
}
