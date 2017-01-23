<?php

namespace Kiboko\Component\TFTConnector\Step;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Step\AbstractStep;

class ApiCacheFetching extends AbstractStep
{
    /**
     * @var array
     */
    private $configuration;

    public function doExecute(StepExecution $stepExecution)
    {
        $file = fopen($stepExecution->getJobParameters()->get('filePath'), 'w');
        $api = fopen('http://api.thefrenchtalents.com/tftapi.svc/partner/offer?api_key=48003038-9bd3-4fb6-afc6-38a7ee0b60eb', 'r');
        stream_copy_to_stream($api, $file);
        fclose($api);
        fclose($file);
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
