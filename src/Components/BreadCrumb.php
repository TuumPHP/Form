<?php
namespace Tuum\Form\Components;

class BreadCrumb implements \IteratorAggregate
{
    const LINK = 'link';
    const NAME = 'name';
    const LAST = 'last';

    private $breads = [];

    /**
     * @var bool
     */
    private $isLast;

    /**
     * @param string $label
     * @param string $link
     */
    public function __construct($label, $link = null)
    {
        $this->breads[] = [
            self::NAME => $label,
            self::LINK => $link,
            self::LAST => true
        ];
    }

    /**
     * @param string $label
     * @param string|null $link
     * @return BreadCrumb
     */
    public static function forge($label, $link = null)
    {
        return new self($label, $link);
    }

    /**
     * @param string $label
     * @param string $link
     * @return $this
     */
    public function add($label, $link)
    {
        $this->breads[] = [self::NAME => $label, self::LINK => $link];
        return $this;
    }

    /**
     * @return array
     */
    public function getReversed()
    {
        $reverse = [];
        for($idx = count($this->breads) - 1; $idx >= 0; $idx--) {
            $reverse[] = $this->breads[$idx];
        }
        return $reverse;
    }

    /**
     * @return bool
     */
    public function isLast()
    {
        return $this->isLast === true
            ? true
            : false;
    }

    /**
     * @return \Generator
     */
    public function getIterator()
    {
        $bread = $this->getReversed();

        foreach($bread as $row) {
            if (isset($row[self::LAST]) && $row[self::LAST]) {
                $this->isLast = true;
            }
            yield $row[self::LINK] => $row[self::NAME];
        }
    }
}
