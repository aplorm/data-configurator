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

namespace Aplorm\DataConfigurator\Exceptions;

use Exception;

class ParameterNotFoundException extends Exception
{
    private const CODE = 0X644;

    public function __construct(string $parameter)
    {
        parent::__construct('parameter :\''.$parameter.'\' not found', self::CODE);
    }
}
