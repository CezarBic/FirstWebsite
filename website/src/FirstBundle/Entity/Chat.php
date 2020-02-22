<?php

namespace FirstBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Chat
 *
 * @ORM\Table(name="chat")
 * @ORM\Entity(repositoryClass="FirstBundle\Repository\ChatRepository")
 */
class Chat
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="messages", type="string", length=255)
     */
    private $messages;

    /**
     * @var string
     *
     * @ORM\Column(name="fromw", type="string", length=255)
     */
    private $fromw;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="time")
     */
    private $created;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set messages.
     *
     * @param string $messages
     *
     * @return Chat
     */
    public function setMessages($messages)
    {
        $this->messages = $messages;

        return $this;
    }

    /**
     * Get messages.
     *
     * @return string
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * Set fromw.
     *
     * @param string $fromw
     *
     * @return Chat
     */
    public function setFromw($fromw)
    {
        $this->fromw = $fromw;

        return $this;
    }

    /**
     * Get fromw.
     *
     * @return string
     */
    public function getFromw()
    {
        return $this->fromw;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Chat
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
}
