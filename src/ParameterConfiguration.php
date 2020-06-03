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

use Aplorm\Common\DataConfigurator\ParameterConfigurationInterface;

class ParameterConfiguration implements ParameterConfigurationInterface
{
    private ?string $type = null;

    /**
     * @var mixed|null
     */
    private $defaultValue;

    private ?bool $nullable = true;

    /**
     * @param array<mixed> $data
     */
    public function __construct(array &$data)
    {
        $this->type = &$data['type'];
        $this->defaultValue = &$data['value'];
        $this->nullable = &$data['nullable'];

        unset($data);
    }

    /**
     * @return string|null the type defined with php7.4 syntax
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @return bool if the return is defined has nullable with php7 syntax
     */
    public function isNullable(): bool
    {
        return $this->nullable;
    }

    /**
     * return default value.
     *
     * @return mixed|null
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
