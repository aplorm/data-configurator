<?php

namespace Aplorm\DataConfigurator\Tests\Sample\TestAnnotations;

use Aplorm\Common\DataConfigurator\AnnotationInterface;

class Annotation3 implements AnnotationInterface
{
    public $data;

    public function __construct(Annotation11 $data)
    {
        $this->data = $data;
    }
}
