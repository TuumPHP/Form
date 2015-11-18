<?php
namespace Tuum\Form\Tags;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

class InputList extends Tag implements IteratorAggregate
{
    use ElementTrait;

    /**
     * @var array|Traversable
     */
    private $list;

    /**
     * @param string            $type
     * @param string            $name
     * @param array|Traversable $list
     * @param null              $value
     */
    public function __construct($type, $name, $list, $value = null)
    {
        parent::__construct('input');
        $this->list = $list;
        $this->setAttribute('type', $type);
        $this->setAttribute('name', $name);
        $this->setAttribute('value', (array)$value);
        if ($type === 'checkbox') {
            $this->setMultiple();
        }
    }

    /**
     * @return string
     */
    public function toString()
    {
        return $this->formInput();
    }

    /**
     * @return string
     */
    private function formInput()
    {
        $html = '<ul>';
        foreach ($this->list as $key => $label) {
            $html .= "\n";
            $html .= '  <li>' . $this->labelHtml($this->getInput($key) . ' ' . $label) . '</li>';
        }
        return $html . "\n</ul>";
    }

    /**
     * @return array
     */
    public function getList()
    {
        return $this->list;
    }

    /**
     * @param string $key
     * @return string
     */
    public function getLabel($key)
    {
        return array_key_exists($key, $this->list) ? $this->list[$key] : '';
    }

    /**
     * @param string $key
     * @return Input
     */
    public function getInput($key)
    {
        if (!array_key_exists($key, $this->list)) {
            return '';
        }
        $input = new Input(null, null);
        $input->fillAttributes($this->getAttribute());
        $input->setAttribute('value', $key);
        $selectedValue = $this->get('value');
        if (in_array((string)$key, $selectedValue)) {
            $input->setAttribute('checked', true);
        }
        return $input;
    }

    /**
     * Retrieve an external iterator
     *
     * @link  http://php.net/manual/en/iteratoraggregate.getiterator.php
     * @return Traversable
     */
    public function getIterator()
    {
        $list = [];
        foreach ($this->list as $key => $value) {
            $list[$key] = $this->getInput($key);
        }
        return new ArrayIterator($list);
    }
}