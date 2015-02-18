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
     * @return mixed
     */
    public function getName()
    {
        return $this->get('name');
    }

    /**
     * @return mixed|null|string
     */
    public function getId()
    {
        if ($id = $this->get('id')) {
            return $id;
        }
        $id = $this->getName();
        $id = str_replace(['[', ']', '_'], '-', $id);
        if (in_array($this->get('type'), ['radio', 'checkbox'])) {
            $id .= '-' . $this->get('value');
        }
        return $id;
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