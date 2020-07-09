<?php


namespace Aplorm\DataConfigurator;


use Aplorm\Common\DataConfigurator\AnnotationInterface;
use Aplorm\DataConfigurator\Exceptions\AnnotationNotFoundException;

trait AnnotedDataInterfaceTrait
{
    /**
     * @var AnnotationInterface[]
     */
    private array $annotations = [];

    /**
     * @return AnnotationInterface[]
     */
    public function getAnnotations(): array
    {
        return array_map(function($reference) {
            if (is_array($reference)) {
                return array_map(function(\WeakReference $ref) {
                    return $ref->get();
                }, $reference);
            }
            return $reference->get();
        }, $this->annotations);
    }

    /**
     * @throws AnnotationNotFoundException
     *
     * @return AnnotationInterface|AnnotationInterface[]
     */
    public function getAnnotation(string $annotation)
    {
        if (!isset($this->annotations[$annotation])) {
            throw new AnnotationNotFoundException($annotation);
        }

        if (is_array($this->annotations[$annotation])) {
            return array_map(function(\WeakReference $reference){
                return $reference->get();
            }, $this->annotations[$annotation]);
        }

        return $this->annotations[$annotation]->get();
    }

    /**
     * @param string $annotation
     * @return bool
     */
    public function hasAnnotation(string $annotation): bool
    {
        return isset($this->annotations[$annotation]);
    }
}
