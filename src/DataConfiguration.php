<?php
/**
 *  This file is part of the Aplorm package.
 *
 *  (c) Nicolas Moral <n.moral@live.fr>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Aplorm\DataConfigurator;

use Aplorm\Common\DataConfigurator\AnnotationInterface;
use Aplorm\Common\DataConfigurator\AttributeConfigurationInterface;
use Aplorm\Common\DataConfigurator\DataConfigurationInterface;
use Aplorm\Common\DataConfigurator\MethodConfigurationInterface;
use Aplorm\Common\Lexer\LexedPartInterface;
use Aplorm\Common\Memory\ObjectJar;
use Aplorm\DataConfigurator\Exceptions\AnnotationNotFoundException;
use Aplorm\DataConfigurator\Exceptions\AttributeNotFoundException;
use Aplorm\DataConfigurator\Exceptions\MethodNotFoundException;

class DataConfiguration implements DataConfigurationInterface
{
    /**
     * @var array<mixed>
     */
    private array $classData = [];

    /**
     * @var AttributeConfiguration[]
     */
    private array $attributesData = [];

    /**
     * @var MethodConfiguration[]
     */
    private array $methodData = [];

    /**
     * @param array<mixed> $data
     */
    public function __construct(array &$data)
    {
        $this->classData = &$data[LexedPartInterface::CLASS_NAME_PART];
        $this->init($data);

        unset($data);
    }

    /**
     * @return AnnotationInterface[]
     */
    public function getClassAnnotations(): iterable
    {
        return array_map(function($reference) {
            if (is_array($reference)) {
                return array_map(function(\WeakReference $ref) {
                    return $ref->get();
                }, $reference);
            }

            return $reference->get();
        }, $this->classData['annotations'] ?? []);
    }

    /**
     * @throws AnnotationNotFoundException
     *
     * @return AnnotationInterface|AnnotationInterface[]
     */
    public function getClassAnnotation(string $annotation)
    {
        if (!isset($this->classData['annotations'][$annotation])) {
            throw new AnnotationNotFoundException($annotation);
        }

        if (is_array($this->classData['annotations'][$annotation])) {
            return array_map(function(\WeakReference $reference) {
                return $reference->get();
            }, $this->classData['annotations'][$annotation]);
        }

        return $this->classData['annotations'][$annotation]->get();
    }

    /**
     * @return AttributeConfigurationInterface[]
     */
    public function getAttributes(): iterable
    {
        return array_map(function(\WeakReference $reference) {
            return $reference->get();
        }, $this->attributesData);
    }

    /**
     * @throws AttributeNotFoundException
     */
    public function getAttribute(string $attribute): AttributeConfigurationInterface
    {
        if (!isset($this->attributesData[$attribute])) {
            throw new AttributeNotFoundException($attribute);
        }

        return $this->attributesData[$attribute]->get();
    }

    /**
     * @throws AttributeNotFoundException
     * @throws AnnotationNotFoundException
     *
     * @return AnnotationInterface|AnnotationInterface[]
     */
    public function getAttributeAnnotation(string $attribute, ?string $annotation = null)
    {
        if (null === $annotation) {
            return $this->getAttribute($attribute)->getAnnotations();
        }

        return $this->getAttribute($attribute)->getAnnotation($annotation);
    }

    /**
     * @return MethodConfigurationInterface[]
     */
    public function getMethods(): iterable
    {
        return array_map(function(\WeakReference $reference) {
            return $reference->get();
        }, $this->methodData);
    }

    /**
     * @throws MethodNotFoundException
     */
    public function getMethod(string $method): MethodConfigurationInterface
    {
        if (!isset($this->methodData[$method])) {
            throw new MethodNotFoundException($method);
        }

        return $this->methodData[$method]->get();
    }

    /**
     * @throws MethodNotFoundException
     * @throws AnnotationNotFoundException
     *
     * @return AnnotationInterface|AnnotationInterface[]
     */
    public function getMethodAnnotation(string $method, ?string $annotation = null)
    {
        if (null === $annotation) {
            return $this->getMethod($method)->getAnnotations();
        }

        return $this->getMethod($method)->getAnnotation($annotation);
    }

    /**
     * @param array<mixed> $data
     */
    protected function init(array &$data): void
    {
        $this->initAttribute($data[LexedPartInterface::VARIABLE_PART]);
        $this->initMethod($data[LexedPartInterface::METHOD_PART]);

        unset($data);
    }

    /**
     * @param array<mixed> $data
     */
    protected function initAttribute(array &$data): void
    {
        foreach ($data as $key => &$value) {
            $this->attributesData[$key] = ObjectJar::add('data-configuration', new AttributeConfiguration($value));
        }

        unset($data);
    }

    /**
     * @param array<mixed> $data
     */
    protected function initMethod(array &$data): void
    {
        foreach ($data as $key => &$value) {
            $this->methodData[$key] = ObjectJar::add('data-configuration', new MethodConfiguration($value));
        }

        unset($data);
    }
}
