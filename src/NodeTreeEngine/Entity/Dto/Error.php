<?php
/**
 * ExecutionParams
 *
 * @package   node-tree-engine
 * @author    Xavier Arnaus <xavier@arnaus.net>
 * @since     2016-12-02
 */

namespace NodeTreeEngine\Entity\Dto;

/**
 * Class Error
 *
 * Meant to handle all data from one given error.
 *
 * @package NodeTreeEngine\Entity\Dto
 */
class Error
{
    /**
     * The message of this error.
     *
     * @var string
     */
    private $message;

    /**
     * The Node that this Error relates to.
     *
     * @var string|null
     */
    private $nodeHash;

    /**
     * When the error happened.
     *
     * @var \DateTime
     */
    private $dateTime;

    /**
     * Error constructor.
     * @param string $message
     * @param null|string $nodeHash
     */
    public function __construct($message, $nodeHash = null)
    {
        $this->message = $message;
        $this->nodeHash = $nodeHash;
        $this->dateTime = new \DateTime('now');
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return null|string
     */
    public function getNodeHash()
    {
        return $this->nodeHash;
    }

    /**
     * @param null|string $nodeHash
     */
    public function setNodeHash($nodeHash)
    {
        $this->nodeHash = $nodeHash;
    }

    /**
     * @return \DateTime
     */
    public function getDateTime()
    {
        return $this->dateTime;
    }

    /**
     * @param \DateTime $dateTime
     */
    public function setDateTime(\DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
    }
}