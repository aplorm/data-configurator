<?php

namespace Aplorm\DataConfigurator\Tests\Sample\TestAnnotations;

use Aplorm\Common\DataConfigurator\AnnotationInterface;

/**
 * @Annotation
 */
class Annotation6 implements AnnotationInterface
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }
}
