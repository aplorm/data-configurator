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
use Aplorm\Common\DataConfigurator\MethodConfigurationInterface;
use Aplorm\Common\DataConfigurator\ParameterConfigurationInterface;
use Aplorm\DataConfigurator\Exceptions\AnnotationNotFoundException;
use Aplorm\DataConfigurator\Exceptions\ParameterNotFoundException;

class MethodConfiguration implements MethodConfigurationInterface
{
    /**
     * @var AnnotationInterface[]
     */
    private array $annotations = [];

    /**
     * @var ParameterConfigurationInterface[];
     */
    private array $parameters = [];

    /**
     * @var array<mixed>
     */
    private array $return = [];

    private ?string $visibility = null;

    /**
     * @var mixed|null
     */
    private $value;

    /**
     * @param array<mixed> $data
     */
    public function __construct(array &$data)
    {
        $this->annotations = &$data['annotations'];
        $this->return = &$data['returnType'];
        $this->visibility = &$data['visibility'];
        $this->value = &$data['value'];
        $this->initParameters($data['parameters']);

        unset($data);
    }

    /**
     * @return AnnotationInterface[]
     */
    public function getAnnotations(): array
    {
        return $this->annotations;
    }

    /**
     * @throws AnnotationNotFoundException
     */
    public function getAnnotation(string $annotation): AnnotationInterface
    {
        if (!isset($this->annotations[$annotation])) {
            throw new AnnotationNotFoundException($annotation);
        }

        return $this->annotations[$annotation];
    }

    public function getReturnType(): ?string
    {
        return $this->return['type'] ?? null;
    }

    public function isReturnNullable(): bool
    {
        return $this->return['nullable'] ?? false;
    }

    /**
     * @return ParameterConfigurationInterface[]
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @throws ParameterNotFoundException
     */
    public function getParameter(string $parameter): ParameterConfigurationInterface
    {
        if (!isset($this->parameters[$parameter])) {
            throw new ParameterNotFoundException($parameter);
        }

        return $this->parameters[$parameter];
    }

    /**
     * @throws ParameterNotFoundException
     */
    public function getParameterType(string $parameter): ?string
    {
        return $this->getParameter($parameter)->getType();
    }

    /**
     * @throws ParameterNotFoundException
     *
     * @return mixed|null
     */
    public function getParameterDefaultValue(string $parameter)
    {
        return $this->getParameter($parameter)->getDefaultValue();
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    /**
     * @param array<mixed> $data
     */
    protected function initParameters(array &$data): void
    {
        foreach ($data as $key => $parameter) {
            $this->parameters[$key] = new ParameterConfiguration($data);
        }

        unset($data);
    }
}
