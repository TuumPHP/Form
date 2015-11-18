<?php
namespace Tuum\Form\Tags;

trait ElementTrait
{
    /**
     * @var bool
     */
    private $multiple = false;

    /**
     * @var string
     */
    private $label;

    abstract function get($name);

    abstract function setAttribute($key, $value, $sep = false);

    /**
     * call multiple *after* name is set.
     *
     * @param bool $multiple
     * @return $this
     */
    public function setMultiple($multiple = true)
    {
        $this->multiple = $multiple;
        $name           = $this->get('name');
        $this->setAttribute('name', $name . '[]');
        return $this;
    }

    /**
     * @param string $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function name($name)
    {
        return $this->setAttribute('name', $name);
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @param null|string $id
     * @return $this
     */
    public function id($id = null)
    {
        if (is_null($id)) {
            $id = $this->getName();
            $id = str_replace(['[', ']', '_'], '-', $id);
            if (in_array($this->get('type'), ['radio', 'checkbox'])) {
                $id .= '-' . $this->get('value');
            }
        }
        $this->setAttribute('id', $id);
        return $this;
    }

    /**
     * @return string
     */
    public function getId()
    {
        $id = $this->get('id');
        if (!$id) {
            $this->id();
        }
        return $this->get('id');
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $content
     * @return string
     */
    protected function labelHtml($content)
    {
        return "<label>{$content}</label>";
    }
}