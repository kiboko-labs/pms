<?php

namespace Kiboko\Component\MagentoConnector\Step;

use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Step\AbstractStep;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\ProcessBuilder;

class IndexRunner extends AbstractStep
{
    /**
     * @var string
     */
    private $index;

    /**
     * @var string
     */
    private $indexerCommandPath;

    /**
     * IndexRunner constructor.
     *
     * @param string $name
     * @param string $indexName
     * @param string $indexerCommandPath
     */
    public function __construct(
        $name,
        $indexName,
        $indexerCommandPath
    ) {
        parent::__construct($name);

        $this->index = $indexName;
        $this->indexerCommandPath = $indexerCommandPath;
    }

    /**
     * @param StepExecution $stepExecution
     *
     * @throws ProcessFailedException
     */
    public function doExecute(StepExecution $stepExecution)
    {
        $builder = new ProcessBuilder(
            [
                '/usr/bin/env',
                'php',
                $this->indexerCommandPath,
                '--reindex',
                $this->index,
            ]
        );

        $process = $builder->getProcess();
        $process->setTimeout(3600);
        $process->run();

        if (!$process->isSuccessful()) {
            $stepExecution->addFailureException(new ProcessFailedException($process));
        }

        $stepExecution->addSummaryInfo('index', $process->getOutput());
    }

    /**
     * @return array
     */
    public function getConfiguration()
    {
        return [
            'index'              => $this->index,
            'indexerCommandPath' => $this->indexerCommandPath,
        ];
    }

    /**
     * @param array $config
     */
    public function setConfiguration(array $config)
    {
        if (isset($config['indexerCommandPath'])) {
            if (is_executable($config['indexerCommandPath'])) {
                $this->indexerCommandPath = $config['indexerCommandPath'];
            }
        }
        if (isset($config['index'])) {
            $this->indexerCommandPath = $config['index'];
        }
    }
}
