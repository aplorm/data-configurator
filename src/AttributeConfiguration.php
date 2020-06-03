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
use Aplorm\DataConfigurator\Exceptions\AnnotationNotFoundException;

class AttributeConfiguration implements AttributeConfigurationInterface
{
    /**
     * @var AnnotationInterface[]
     */
    private array $annotations = [];
    private ?string $type = null;
    private ?string $visibility = null;
    private bool $nullable = true;

    /**
     * @var mixed|null
     */
    private $value;

    /**
     * @param array<mixed> $data
     */
    public function __construct(array &$data)
    {
        var_dump($data);
        $this->annotations = &$data['annotations'];
        $this->type = &$data['type'];
        $this->visibility = &$data['visibility'];
        $this->value = &$data['value'];
        $this->nullable = &$data['nullable'] ?? true;

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

    /**
     * @return string|null the type defined with php7.4 syntax
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * return default value.
     *
     * @return mixed|null
     */
    public function getDefaultValue()
    {
        return $this->value;
    }

    public function getVisibility(): ?string
    {
        return $this->visibility;
    }

    /**
     * @return bool if the return is defined has nullable with php7 syntax
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }
}
