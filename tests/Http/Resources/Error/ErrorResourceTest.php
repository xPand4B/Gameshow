<?php

namespace Tests\Http\Resources\Error;

use App\Helper\MessageResponse;
use App\Http\Resources\Error\ErrorResource;
use Tests\TestCase;

class ErrorResourceTest extends TestCase
{
    private \ReflectionClass $class;

    public function setUp(): void
    {
        parent::setUp();
        $this->class = new \ReflectionClass(ErrorResource::class);
    }

    /** @test */
    public function test_class_has_all_required_properties(): void
    {
        $expected = [
            'id',
            'linkAbout',
            'statusCode',
            'applicationErrorCode',
            'title',
            'detail',
            'sourcePointer',
            'sourceParameter',
            'meta',
            'errorCollection'
        ];

        self::assertSame(10, sizeof($this->class->getProperties()));

        foreach ($this->class->getProperties() as $key => $property) {
            self::assertSame($expected[$key], $property->name);
        }
    }

    /** @test */
    public function test_class_has_all_required_setter(): void
    {
        $expected = [
            'setId' => [
                'params' => ['id'],
            ],
            'setLinks' => [
                'params' => ['about'],
            ],
            'setStatusCode' => [
                'params' => ['code'],
            ],
            'setCode' => [
                'params' => ['code'],
            ],
            'setTitle' => [
                'params' => ['title'],
            ],
            'setDetail' => [
                'params' => ['detail'],
            ],
            'setSource' => [
                'params' => ['pointer', 'parameter'],
            ],
            'setMeta' => [
                'params' => ['meta'],
            ],
        ];

        foreach ($expected as $method => $meta) {
            self::assertTrue($this->class->hasMethod($method));

            $method = $this->class->getMethod($method);
            $params = $meta['params'];

            foreach ($method->getParameters() as $key => $parameter) {
                self::assertSame($params[$key], $parameter->getName());
            }

            self::assertTrue($method->hasReturnType());
            self::assertTrue($method->isPublic());

            self::assertFalse($method->isStatic());
        }
    }

    /** @test */
    public function test_class_can_handle_single_error(): void
    {
        $errorResource = (new ErrorResource())
            ->setId('1')
            ->setLinks('https://xpand4b.de')
            ->setStatusCode(400)
            ->setCode('1337')
            ->setTitle('This is a sample error message')
            ->setDetail('Only occurs while testing the ErrorResource class.')
            ->setSource('/gameshow/core/phpunit/ErrorResourceTest', 'Sample')
            ->setMeta(['message' => 'Some meta information.'])
            ->getError();

        self::assertJson($errorResource->getContent());
        self::assertSame(400, $errorResource->getStatusCode());
        self::assertSame(json_encode([
            'errors' => [
                [
                    'id' => '1',
                    'links' => [
                        'about' => 'https://xpand4b.de'
                    ],
                    'status' => 400,
                    'code' => '1337',
                    'title' => 'This is a sample error message',
                    'detail' => 'Only occurs while testing the ErrorResource class.',
                    'source' => [
                        'pointer' => '/gameshow/core/phpunit/ErrorResourceTest',
                        'parameter' => 'Sample',
                    ],
                    'meta' => [
                        'message' => 'Some meta information.',
                    ],
                ],
            ],
        ]), $errorResource->getContent());
    }

    /** @test */
    public function test_class_can_handle_error_collection(): void
    {
        $errorResource = new ErrorResource();
        $errorResource->addError(...$this->getSampleError());
        $errorResource->addError(...$this->getSampleError());

        $result = $errorResource
            ->setStatusCode(400)
            ->getErrorCollection();

        self::assertJson($result->getContent());
        self::assertSame(400, $result->getStatusCode());
        self::assertSame(json_encode([
            'errors' => [
                [
                    'id' => '1',
                    'links' => [
                        'about' => 'https://xpand4b.de'
                    ],
                    'status' => 401,
                    'code' => '1337',
                    'title' => 'This is a sample error message',
                    'detail' => 'Only occurs while testing the ErrorResource class.',
                    'source' => [
                        'pointer' => '/gameshow/core/phpunit/ErrorResourceTest',
                        'parameter' => 'Sample',
                    ],
                    'meta' => [
                        'message' => 'Some meta information.',
                    ],
                ],
                [
                    'id' => '1',
                    'links' => [
                        'about' => 'https://xpand4b.de'
                    ],
                    'status' => 401,
                    'code' => '1337',
                    'title' => 'This is a sample error message',
                    'detail' => 'Only occurs while testing the ErrorResource class.',
                    'source' => [
                        'pointer' => '/gameshow/core/phpunit/ErrorResourceTest',
                        'parameter' => 'Sample',
                    ],
                    'meta' => [
                        'message' => 'Some meta information.',
                    ],
                ],
            ],
        ]), $result->getContent());
    }

    private function getSampleError(): array
    {
        return [
            '1',
            'https://xpand4b.de',
            401,
            '1337',
            'This is a sample error message',
            'Only occurs while testing the ErrorResource class.',
            '/gameshow/core/phpunit/ErrorResourceTest',
            'Sample',
            [
                'message' => 'Some meta information.'
            ]
        ];
    }
}
