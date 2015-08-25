<?php
/**
 * @file
 */

namespace Broadway\EventHandling;

use Broadway\Domain\DomainEventStreamInterface;

class ReplayAwareEventBus extends SimpleEventBus implements ReplayAwareInterface
{

    /**
     * Invoked when a replay is started.
     */
    public function beforeReplay()
    {
        foreach($this->eventListeners as $eventListener)
        {
            if($eventListener instanceof ReplayAwareInterface)
            {
                $eventListener->beforeReplay();
            }
        }
        return $this;
    }

    /**
     * Invoked when a replay has finished.
     */
    public function afterReplay()
    {
        foreach($this->eventListeners as $eventListener)
        {
            if($eventListener instanceof ReplayAwareInterface)
            {
                $eventListener->afterReplay();
            }
        }
        return $this;
    }

    /**
     * Invoked when a replay has failed due to an exception.
     *
     * @param \Exception $cause The exception that stopped the replay;
     */
    public function onReplayFailed(\Exception $cause = null)
    {
        // TODO: Implement onReplayFailed() method.
    }
}
