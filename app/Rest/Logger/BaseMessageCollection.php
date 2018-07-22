<?php
/**
 * Created by PhpStorm.
 * User: tuman
 * Date: 2018-07-16
 * Time: 2:04
 */

namespace App\Rest\Logger;

class BaseMessageCollection
{
    use MessageCollection;

    const BAD_REQUEST = 400;

    public function initializeMessages()
    {
        $this->addMessage(new Message(self::BAD_REQUEST, 'test'));
        $this->addMessage(new Message(401, 'test'));
        $this->addMessage(new Message(402, 'test'));
        $this->addMessage(new Message(403, 'test'));

        $this->addMessageCollection(UserMessagesCollection::getInstance());


    }
}