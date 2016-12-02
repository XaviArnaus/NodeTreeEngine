<?php
/**
 * NodeAbstract
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
 * Class NodeAbstract
 *
 * Meant to be extended from all Nodes that will take part on the engine.
 *
 * @package NodeTreeEngine\Entity
 */
abstract class NodeAbstract implements NodeInterface
{
    /**
     * ID of the Node.
     *
     * @var string
     */
    private $nodeHash;

    /**
     * Name of the Node.
     *
     * @var string
     */
    private $nodeName;

    /**
     * List of connectors that links this Node to one or several parents.
     *
     * @var NodeConnector[]
     */
    private $nodeConnectors = [];

    /**
     * List of parameters this Node receives from the configuration.
     *
     * @var array
     */
    private $parameters = [];

    /**
     * The parameters that are required to be loaded in order to execute this step.
     *
     * @var array
     */
    private $mandatoryParameters = [];

    /**
     * List of errors produced by this Node.
     *
     * @var Error[]
     */
    private $errors = [];

    /**
     * The output object for this Node.
     *
     * @var ExecutionOutput|null
     */
    private $output = null;

    /**
     * @return string
     */
    public function getNodeHash()
    {
        return $this->nodeHash;
    }

    /**
     * @param string $nodeHash
     */
    public function setNodeHash($nodeHash)
    {
        $this->nodeHash = $nodeHash;
    }

    /**
     * @return string
     */
    public function getNodeName()
    {
        return $this->nodeName;
    }

    /**
     * @param string $nodeName
     */
    public function setNodeName($nodeName)
    {
        $this->nodeName = $nodeName;
    }

    /**
     * Get the NodeConnectors of this Node.
     *
     * @return NodeConnector[]
     */
    public function getNodeConnectors()
    {
        return $this->nodeConnectors;
    }

    /**
     * Set the whole set of NodeConnectors of this Node.
     *
     * @param NodeConnector[] $nodeConnectors
     */
    public function setNodeConnectors($nodeConnectors)
    {
        $this->nodeConnectors = $nodeConnectors;
    }

    /**
     * Add a NodeConnector to this Node.
     *
     * @param NodeConnector $nodeConnector
     */
    public function addNodeConnector(NodeConnector $nodeConnector)
    {
        $this->nodeConnectors[] = $nodeConnector;
    }

    /**
     * Checks if a parent node hash is present in this Node.
     *
     * @param $nodeHash
     * @return bool
     */
    public function hasParentNodeAsConnection($nodeHash)
    {
        return (count(array_filter(array_map(function(NodeConnector $nodeConnector) use ($nodeHash) {
            if ($nodeConnector->hasParentNodeHash())
            {
                return ($nodeConnector->getParentNodeHash() == $nodeHash);
            }
            return false;
        }, $this->nodeConnectors))) > 0);
    }

    /**
     * Checks if the given NodeConnector matches with any NodeConnector set up in this Node.
     *
     * @param NodeConnector $requestingNodeConnector
     * @return bool
     */
    public function matchesWith(NodeConnector $requestingNodeConnector)
    {
        return (count(array_filter(array_map(function(NodeConnector $nodeConnector) use ($requestingNodeConnector)
        {
            return (
                $nodeConnector->getParentNodeHash() == $requestingNodeConnector->getParentNodeHash() &&
                $nodeConnector->getExpectedResult() == $requestingNodeConnector->getExpectedResult()
            );
        }, $this->nodeConnectors))) > 0);
    }

    /**
     * Gets all Parameters.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Checks if the parameter exists in this Node.
     *
     * @param string
     * @return bool
     */
    public function hasParameter($parameterKey)
    {
        return array_key_exists($parameterKey, $this->parameters);
    }

    /**
     * Get the parameter related to the given Key.
     *
     * @param string
     * @return mixed|null
     */
    public function getParameter($parameterKey)
    {
        return $this->hasParameter($parameterKey) ? $this->parameters[$parameterKey] : null;
    }

    /**
     * Loads the parameters to set up the Node.
     *
     * @param array|null $parameters
     */
    public function loadParameters(array $parameters)
    {
        foreach ($parameters as $key => $value)
        {
            // If the parameter already exists, do a merge for arrays and overwrite for the rest.
            if ($this->hasParameter($key) && is_array($value))
            {
                $this->parameters[$key] = array_merge($this->parameters[$key], $value);
            }
            else
            {
                $this->parameters[$key] = $value;
            }
        }
    }

    /**
     * Verifies the step itself with the parameters received and returns an answer.
     *
     * @return bool
     */
    public function isStepValid()
    {
        foreach ($this->mandatoryParameters as $parameter => $type)
        {
            if (!array_key_exists($parameter, $this->parameters) || gettype($this->parameters[$parameter]) !== $type)
            {
                $this->logError('Missing parameter "' . $parameter . '"');

                return false;
            }
        }

        return true;
    }

    /**
     * Gets all Mandatory Parameters.
     *
     * @return array
     */
    public function getMandatoryParameters()
    {
        return $this->mandatoryParameters;
    }

    /**
     * Sets all Mandatory Parameters.
     *
     * @param array $mandatoryParameters
     */
    public function setMandatoryParameters(array $mandatoryParameters)
    {
        $this->mandatoryParameters = $mandatoryParameters;
    }

    /**
     * Pre execution actions.
     *
     * @param ExecutionParams $params
     */
    public function preExecute(ExecutionParams $params)
    {
    }

    /**
     * Post execution actions.
     *
     * @param ExecutionParams $params
     */
    public function postExecute(ExecutionParams $params)
    {
    }

    /**
     * Gets all Errors.
     *
     * @return Error[]
     */
    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Logs an Error.
     *
     * @param $message
     */
    public function logError($message)
    {
        $this->errors[] = new Error(
            $message,
            $this->getNodeHash()
        );
    }

    /**
     * Gets the output of this Node execution.
     *
     * @return ExecutionOutput
     */
    public function getOutput()
    {
        return (is_null($this->output) ? new ExecutionOutput() : $this->output);
    }

    /**
     * Sets the output of this Node execution.
     *
     * @param ExecutionOutput $output
     */
    public function setOutput(ExecutionOutput $output)
    {
        $this->output = $output;
    }

    /**
     * Force the current execution to be stopped.
     *
     * @param $message
     * @throws StopExecutionException
     */
    public function stopExecution($message)
    {
        throw new StopExecutionException('[' . $this->getNodeName() . '] ' . $message);
    }
}