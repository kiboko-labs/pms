<?php

namespace Kiboko\Component\TFTConnector\Step;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Step\AbstractStep;

class ApiCacheCleanup extends AbstractStep
{
    /**
     * @var array
     */
    private $configuration;

    public function doExecute(StepExecution $stepExecution)
    {
        $file = $stepExecution->getExecutionContext()->get('filePath');
        unlink($file);
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param array $config
     */
    public function setConfiguration(array $config)
    {
        $this->configuration = $config;
    }
}
