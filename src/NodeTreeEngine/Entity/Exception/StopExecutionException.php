<?php
/**
 * StopExecutionException
 *
 * @package   node-tree-engine
 * @author    Xavier Arnaus <xavier@arnaus.net>
 * @since     2016-12-02
 */

namespace NodeTreeEngine\Entity\Exception;

/**
 * Class StopExecutionException
 *
 * Identifies when a Node requests to stop the full execution.
 *
 * @package NodeTreeEngine\Entity\Exception
 */
class StopExecutionException extends \Exception {}