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

namespace Aplorm\DataConfigurator\Tests\DataConfiguration;

use Aplorm\Common\Lexer\LexedPartInterface;
use Aplorm\Common\Test\AbstractTest;
use Aplorm\Interpreter\Exception\ClassNotFoundException;
use Aplorm\Interpreter\Exception\ClassPartNotFoundException;
use Aplorm\Interpreter\Exception\ConstantNotFoundException;
use Aplorm\Interpreter\Exception\InvalidAnnotationConfigurationException;
use Aplorm\Interpreter\Exception\WrongAnnotationTypeException;
use Aplorm\Interpreter\Interpreter;
use Aplorm\Lexer\Lexer\Lexer;

class FailTest extends AbstractTest
{
    /**
     * function call in setUp function.
     */
    protected function doSetup(): void
    {
    }

    /**
     * function call in tearDown function.
     */
    protected function doTearDown(): void
    {
    }

    public static function setupBeforeClass(): void
    {
    }

    public static function tearDownAfterClass(): void
    {
    }
}
