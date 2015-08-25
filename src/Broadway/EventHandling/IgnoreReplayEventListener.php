<?php
/**
 * @file
 */

namespace Broadway\EventHandling;

use Broadway\Domain\DomainMessage;

class IgnoreReplayEventListener implements EventListenerInterface, ReplayAwareInterface
{
    private $eventListener;
    private $isReplay = false;

    function __construct(EventListenerInterface $eventListener)
    {
        $this->eventListener = $eventListener;
    }


    public function handle(DomainMessage $domainMessage)
    {
        if(! $this->isReplay)
        {
            $this->eventListener->handle($domainMessage);
        }
        return $this;
    }

    /**
     * Invoked when a replay is started.
     */
    public function beforeReplay()
    {
        $this->isReplay = true;
        return $this;
    }

    /**
     * Invoked when a replay has finished.
     */
    public function afterReplay()
    {
        $this->isReplay = false;
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
