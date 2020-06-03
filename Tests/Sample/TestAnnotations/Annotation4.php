<?php

namespace Aplorm\DataConfigurator\Tests\Sample\TestAnnotations;

use Aplorm\Common\DataConfigurator\AnnotationInterface;

class Annotation4 implements AnnotationInterface
{
    public $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }
}
