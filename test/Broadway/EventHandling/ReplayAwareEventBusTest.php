<?php
/**
 * @file
 */

namespace Broadway\EventHandling;

use Broadway\TestCase;

class ReplayAwareEventBusTest extends TestCase
{

    /**
     * @var \Broadway\EventHandling\ReplayAwareEventBus
     */
    private $eventBus;
    /**
     * @var \Broadway\EventHandling\ReplayAwareInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $replayAwareEventListenerMock;
    /**
     * @var \Broadway\EventHandling\EventListenerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $replayUnawareEventListenerMock;

    public function setUp()
    {
        $this->eventBus = new ReplayAwareEventBus();

        $this->replayAwareEventListenerMock = $this->createReplayAwareEventListenerMock();
        $this->replayUnawareEventListenerMock = $this->createEventListenerMock();

        $this->eventBus
            ->subscribe($this->replayAwareEventListenerMock);

        $this->eventBus
            ->subscribe($this->replayUnawareEventListenerMock);
    }

    /**
     * @test
     */
    public function it_delegates_before_replay_to_replay_aware_eventlisteners()
    {

        $this->replayAwareEventListenerMock
            ->expects($this->once())
            ->method('beforeReplay');

        $this->eventBus
            ->beforeReplay();

    }

    /**
     * @test
     */
    public function it_delegates_after_replay_to_replay_aware_eventlisteners()
    {

        $this->replayAwareEventListenerMock
            ->expects($this->once())
            ->method('afterReplay');

        $this->eventBus
            ->afterReplay();

    }

    private function createEventListenerMock()
    {
        return $this->getMockBuilder('Broadway\EventHandling\EventListenerInterface')->getMock();
    }

    private function createReplayAwareEventListenerMock()
    {
        return $this->getMockBuilder('Broadway\EventHandling\ReplayAwareEventListener')->getMock();
    }

}

abstract class ReplayAwareEventListener implements EventListenerInterface, ReplayAwareInterface {

}
