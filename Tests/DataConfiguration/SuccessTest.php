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

use Aplorm\Common\Memory\ObjectJar;
use Aplorm\Common\Test\AbstractTest;
use Aplorm\DataConfigurator\DataConfiguration;
use Aplorm\DataConfigurator\Exceptions\AnnotationNotFoundException;
use Aplorm\DataConfigurator\Exceptions\AttributeNotFoundException;
use Aplorm\DataConfigurator\Tests\Sample\InterpreterClassTest;
use Aplorm\DataConfigurator\Tests\Sample\TestAnnotations\Annotation7;
use Aplorm\Interpreter\Interpreter;
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
        ObjectJar::clean();
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
     * @param string  $fileName
     * @param int[]   $multipleAnnotations
     * @param mixed[] $attributesValue
     * @param mixed[] $functionValue
     *
     * @throws AnnotationNotFoundException
     * @throws AttributeNotFoundException
     */
    public function testDataConfiguration(
        $fileName,
        int $classAnnotationsNumber,
        array $multipleAnnotations,
        array $attributesValue,
        array $functionValue
    ): void {
        $time = microtime(true);
        $mem = memory_get_usage();
        $parts = Lexer::analyse($fileName);
        Interpreter::interprete($parts);
        $dc = new DataConfiguration($parts);
        var_dump(microtime(true) - $time, (memory_get_usage() - $mem) / 1024);
        self::assertCount($classAnnotationsNumber, $dc->getClassAnnotations());
        foreach ($multipleAnnotations as $annotation => $size) {
            self::assertCount($size, $dc->getClassAnnotation($annotation));
        }

        foreach ($attributesValue as $attribute => $value) {
            self::assertNotNull($dc->getAttribute($attribute));
            self::assertEquals($value, $dc->getAttribute($attribute)->getDefaultValue());
        }
        foreach ($functionValue as $name => $configuration) {
            self::assertNotNull($dc->getMethod($name));
            $functionConfiguration = $dc->getMethod($name);
            self::assertCount($configuration['annotations'], $functionConfiguration->getAnnotations());
            self::assertEquals($configuration['returnType'], $functionConfiguration->getReturnType());
            self::assertEquals($configuration['isNullable'], $functionConfiguration->isReturnNullable());
            foreach ($configuration['parameter'] as $paramName => $paramValue) {
                self::assertNotNull($functionConfiguration->getParameter($paramName));
                $paramConfiguration = $functionConfiguration->getParameter($paramName);
                self::assertEquals($paramValue['type'], $paramConfiguration->getType());
                self::assertEquals($paramValue['value'], $paramConfiguration->getDefaultValue());
            }
        }
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
            8,
            [
                Annotation7::class => 2,
            ],
            [
                'string' => 'une string avec des espaces',
            ],
            [
                'mafunction' => [
                    'annotations' => 1,
                    'returnType' => 'bool',
                    'isNullable' => false,
                    'parameter' => [
                        'param1' => [
                            'type' => 'string',
                            'value' => InterpreterClassTest::A_CONSTANT,
                        ],
                        'param2' => [
                            'type' => 'bool',
                            'value' => true,
                        ],
                    ],
                ],
            ],
        ];
    }
}
