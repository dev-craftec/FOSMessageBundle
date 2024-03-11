<?php

namespace FOS\MessageBundle\Event;

use FOS\MessageBundle\Model\MessageInterface;
use FOS\MessageBundle\Event\ThreadEvent;

class MessageEvent extends ThreadEvent
{
    /**
     * @var MessageInterface
     */
    private $message;

    public function __construct(MessageInterface $message)
    {
        parent::__construct($message->getThread());

        $this->message = $message;
    }

    /**
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }
}
