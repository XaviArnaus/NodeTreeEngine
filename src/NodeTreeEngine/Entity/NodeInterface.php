<?php
/**
 * NodeInterface
 *
 * @package   node-tree-engine
 * @author    Xavier Arnaus <xavier@arnaus.net>
 * @since     2016-12-02
 */

namespace NodeTreeEngine\Entity;

use NodeTreeEngine\Entity\Dto\Error;
use NodeTreeEngine\Entity\Dto\ExecutionOutput;
use NodeTreeEngine\Entity\Dto\ExecutionParams;
use NodeTreeEngine\Entity\Exception\StopExecutionException;

/**
 * Interface NodeInterface
 *
 * Meant to be the contract to base all Nodes from
 *
 * @package NodeTreeEngine\Entity
 */
interface NodeInterface
{
    /**
     * @return string
     */
    public function getNodeHash();

    /**
     * @param string $nodeHash
     */
    public function setNodeHash($nodeHash);

    /**
     * @return string
     */
    public function getNodeName();

    /**
     * @param string $nodeName
     */
    public function setNodeName($nodeName);

    /**
     * Get the NodeConnectors of this Node.
     *
     * @return NodeConnector[]
     */
    public function getNodeConnectors();

    /**
     * Set the whole set of NodeConnectors of this Node.
     *
     * @param NodeConnector[] $nodeConnectors
     */
    public function setNodeConnectors($nodeConnectors);

    /**
     * Add a NodeConnector to this Node.
     *
     * @param NodeConnector $nodeConnector
     */
    public function addNodeConnector(NodeConnector $nodeConnector);

    /**
     * Checks if a parent node hash is present in this Node.
     *
     * @param $nodeHash
     * @return bool
     */
    public function hasParentNodeAsConnection($nodeHash);

    /**
     * Checks if the given NodeConnector matches with any NodeConnector set up in this Node.
     *
     * @param NodeConnector $requestingNodeConnector
     * @return bool
     */
    public function matchesWith(NodeConnector $requestingNodeConnector);

    /**
     * Gets all Parameters.
     *
     * @return array
     */
    public function getParameters();

    /**
     * Checks if the parameter exists in this Node.
     *
     * @param string
     * @return bool
     */
    public function hasParameter($parameterKey);

    /**
     * Get the parameter related to the given Key.
     *
     * @param string
     * @return mixed|null
     */
    public function getParameter($parameterKey);

    /**
     * Loads the parameters to set up the Node.
     *
     * @param array|null $parameters
     */
    public function loadParameters(array $parameters);

    /**
     * Verifies the step itself with the parameters received and returns an answer.
     *
     * @return bool
     */
    public function isStepValid();

    /**
     * Gets all Mandatory Parameters.
     *
     * @return array
     */
    public function getMandatoryParameters();

    /**
     * Sets all Mandatory Parameters.
     *
     * @param array $mandatoryParameters
     */
    public function setMandatoryParameters(array $mandatoryParameters);

    /**
     * Pre execution actions.
     *
     * @param ExecutionParams $params
     */
    public function preExecute(ExecutionParams $params);

    /**
     * @param ExecutionParams $params
     */
    public function execute(ExecutionParams $params);

    /**
     * Post execution actions.
     *
     * @param ExecutionParams $params
     */
    public function postExecute(ExecutionParams $params);

    /**
     * Gets all Errors.
     *
     * @return Error[]
     */
    public function getErrors();

    /**
     * Logs an Error.
     *
     * @param $message
     */
    public function logError($message);;

    /**
     * Gets the output of this Node execution.
     *
     * @return ExecutionOutput
     */
    public function getOutput();

    /**
     * Sets the output of this Node execution.
     *
     * @param ExecutionOutput $output
     */
    public function setOutput(ExecutionOutput $output);

    /**
     * Force the current execution to be stopped.
     *
     * @param $message
     * @throws StopExecutionException
     */
    public function stopExecution($message);
}