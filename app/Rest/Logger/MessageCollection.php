<?php
/**
 * Created by PhpStorm.
 * User: tuman
 * Date: 2018-07-16
 * Time: 2:04
 */

namespace App\Rest\Logger;

use App\Helpers\Singleton;

trait MessageCollection
{
    use Singleton;

    /**
     * @var Message[]
     */
    protected $messages = [];
    /**
     * @var Message
     */
    protected $defaultMessage;

    /**
     * @return Message[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }

    public function initializeMessages()
    {
        $this->addMessage(new Message(400, 'test'));
    }

    public function getMessage($key): Message
    {
        $message = array_get($this->messages, $key, false);

        return ($message instanceof Message)
            ? clone $message
            : $this->getDefaultMessage();
    }

    public function addMessage(Message $message): self
    {
        array_set($this->messages, $message->getCode(), $message);

        return $this;
    }

    public function createMessage(int $code, string $textTemplate): self
    {
        $this->addMessage(new Message($code, $textTemplate));

        return $this;
    }

    public function addMessageCollection(MessageCollectionInterface $collection): self
    {
        array_set($this->messages, $collection->getCollectionKey(), $collection->getMessages());

        return $this;
    }
}