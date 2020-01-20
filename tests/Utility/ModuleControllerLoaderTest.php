<?php

namespace WigeDev\JasperCoreTests\Utility;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use WigeDev\JasperCore\Lifecycle\Response;

class ModuleControllerLoaderTest extends TestCase
{
    /** @var MockObject */
    protected $mockResponse;

    public function testLoad()
    {
        $this->markTestIncomplete('todo');
    }

    public function testLoadError()
    {
        $this->markTestIncomplete('todo');
    }

    public function testLoadErrorModule()
    {
        $this->markTestIncomplete('todo');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockResponse = $this->getMockBuilder(Response::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getStatusCode', 'getModule', 'getController', 'getAction', 'setStatusCode', 'getVariables'])
            ->getMock();
    }
}
