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
use Aplorm\DataConfigurator\DataConfiguration;
use Aplorm\Interpreter\Interpreter;
use Aplorm\Interpreter\Tests\Sample\SampleClass;
use Aplorm\Interpreter\Tests\Sample\TestAnnotations\Annotation7;
use Aplorm\Interpreter\Tests\Sample\TestAnnotations\Annotation;
use Aplorm\Lexer\Lexer\Lexer;

class SuccessTest extends AbstractTest
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

    /**
     * @dataProvider classFileProvider
     *
     * @param string $fileName
     */
    public function testDataConfiguration($fileName): void
    {
        $parts = Lexer::analyse($fileName);
        Interpreter::interprete($parts);
        $dc = new DataConfiguration($parts);
        var_dump($dc);
        self::assertTrue(true);
    }

    /**
     * @return array<mixed>
     */
    public function classFileProvider(): iterable
    {
        if (isset($_SERVER['TRAVIS_BUILD_DIR'])) {
            $dir = $_SERVER['TRAVIS_BUILD_DIR'].'/'.$_ENV['SAMPLE_CLASSES'];
        } else {
            $dir = $_ENV['PWD'].'/'.$_ENV['SAMPLE_CLASSES'];
        }

        yield [
            $dir.'/InterpreterClassTest.php',
        ];
    }
}
