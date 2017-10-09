<?php
namespace Tuum\Form\Data;

use Traversable;

/**
 * Class Message
 *
 * @package Tuum\View\Values
 */
class Message implements \IteratorAggregate
{
    const MESSAGE = 'message';
    const ALERT   = 'alert';
    const ERROR   = 'error';

    /**
     * @var array
     */
    protected $messages = [];

    public $formats = [
        self::MESSAGE => '<div class="alert alert-success">%s</div>',
        self::ALERT   => '<div class="alert alert-info">%s</div>',
        self::ERROR   => '<div class="alert alert-danger">%s</div>',
    ];

    /**
     * @param array $data
     */
    private function __construct($data = [])
    {
        $this->messages = $data;
    }

    /**
     * @param array $data
     * @return Message
     */
    public static function forge($data)
    {
        return new self($data);
    }

    /**
     * @param string $message
     * @param string $type
     */
    public function add($message, $type = self::MESSAGE)
    {
        $this->messages[] = ['message' => $message, 'type' => $type];
    }

    /**
     * @param array $msg
     * @return string
     */
    private function show($msg)
    {
        $type   = isset($msg['type']) ? $msg['type'] : self::MESSAGE;
        $format = isset($this->formats[$type]) ? $this->formats[$type] : $this->formats[self::MESSAGE];
        return sprintf($format, $msg['message']);
    }

    /**
     * show the most severe message only once.
     *
     * @return string
     */
    public function onlyOne()
    {
        $serious   = $this->findMostSerious();
        if (!empty($serious)) {
            return $this->show($serious);
        }
        return '';
    }

    /**
     * @return string[]
     */
    public function findMostSerious()
    {
        $msgScores = [
            self::ERROR   => 3,
            self::ALERT   => 2,
            self::MESSAGE => 1,
        ];
        $serious   = array_reduce(
            $this->messages,
            function ($carry, $msg) use ($msgScores) {
                $myScore      = $msgScores[$msg['type']];
                $msg['score'] = $myScore;
                return $myScore > $carry['score'] ? $msg : $carry;
            },
            ['message' => false, 'type' => self::MESSAGE, 'score' => 0]);
        if ($serious && $serious['message']) {
            return $serious;
        }
        return [];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $html = '';
        foreach ($this->messages as $msg) {
            $html .= $this->show($msg);
        }
        return $html;
    }

    /**
     * Retrieve an external iterator
     *
     * @return Traversable|string[]
     */
    public function getIterator()
    {
        foreach($this->messages as $message) {
            yield $message['type'] => $message['message'];
        }
    }
}