<?php

namespace Aplorm\DataConfigurator\Tests\Sample\TestAnnotations;

use Aplorm\Common\DataConfigurator\AnnotationInterface;

/**
 * @Annotation
 */
class Annotation8 implements AnnotationInterface
{
    public $a;
    public $b;
    public $c;
    public $d;

    public function __construct($args)
    {
        $this->a = 1;
        $this->b = 2;
        $this->c = 2;
        $this->d = 2;
    }
}

