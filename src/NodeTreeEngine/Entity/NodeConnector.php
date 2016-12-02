<?php
/**
 * NodeConnector
 *
 * @package   node-tree-engine
 * @author    Xavier Arnaus <xavier@arnaus.net>
 * @since     2016-12-02
 */

namespace NodeTreeEngine\Entity;

/**
 * Class NodeConnector
 *
 * Used to manage the connection between one Node and it's parent.
 *
 * @package NodeTreeEngine\Entity
 */
class NodeConnector
{
    /**
     * The reference to the parent Node.
     *
     * @var string|null
     */
    private $parentNodeHash = null;

    /**
     * The expected result from the parent Node.
     *
     * @var mixed
     */
    private $expectedResult = null;

    /**
     * @return bool
     */
    public function hasParentNodeHash()
    {
        return !is_null($this->parentNodeHash);
    }

    /**
     * @return null|string
     */
    public function getParentNodeHash()
    {
        return $this->parentNodeHash;
    }

    /**
     * @param null|string $parentNodeHash
     */
    public function setParentNodeHash($parentNodeHash)
    {
        $this->parentNodeHash = $parentNodeHash;
    }

    /**
     * @return bool
     */
    public function hasExpectedResult()
    {
        return !is_null($this->expectedResult);
    }

    /**
     * @return mixed
     */
    public function getExpectedResult()
    {
        return $this->expectedResult;
    }

    /**
     * @param mixed $expectedResult
     */
    public function setExpectedResult($expectedResult)
    {
        $this->expectedResult = $expectedResult;
    }


}