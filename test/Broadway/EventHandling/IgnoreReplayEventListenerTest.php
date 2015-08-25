<?php
/**
 * @file
 */

namespace Broadway\EventHandling;

use Broadway\Domain\DomainEventStream;
use Broadway\Domain\DomainMessage;
use Broadway\Domain\Metadata;
use Broadway\TestCase;

class IgnoreReplayEventListenerTest extends TestCase
{

    /**
     * @var \Broadway\EventHandling\IgnoreReplayEventListener
     */
    private $eventListener;
    /**
     * @var \Broadway\EventHandling\EventListenerInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $eventListenerMock;

    public function setUp()
    {
        $this->eventListenerMock = $this->createEventListenerMock();
        $this->eventListener = new IgnoreReplayEventListener($this->eventListenerMock);
    }

    private function createEventListenerMock()
    {
        return $this->getMockBuilder('Broadway\EventHandling\EventListenerInterface')->getMock();
    }

    /**
     * @test
     */
    public function it_delegates_handling_to_a_decorated_event_listener()
    {
        $domainMessage = $this->createDomainMessage();

        $this->eventListenerMock
            ->expects($this->once())
            ->method('handle')
            ->with($domainMessage);

        $this->eventListener
            ->handle($domainMessage);

    }

    /**
     * @test
     */
    public function it_does_not_delegate_handling_to_a_decorated_event_listener_during_replay()
    {
        $domainMessage = $this->createDomainMessage();

        $this->eventListenerMock
            ->expects($this->never())
            ->method('handle')
            ->with($domainMessage);

        $this->eventListener
            ->beforeReplay()
            ->handle($domainMessage)
            ->afterReplay();

    }


    private function createDomainMessage($par = '')
    {
        return DomainMessage::recordNow(1, 1, new Metadata(array()), array('par' => $par));
    }
}
