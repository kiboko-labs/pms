<?php

namespace Kiboko\Component\TFTConnector\Job;

use Akeneo\Bundle\BatchBundle\Entity\JobExecution;
use Akeneo\Bundle\BatchBundle\Entity\JobInstance;
use Akeneo\Bundle\BatchBundle\Entity\StepExecution;
use Akeneo\Bundle\BatchBundle\Job\JobRepositoryInterface;

class JobRepository implements JobRepositoryInterface
{
    /**
     * Create a JobExecution object
     *
     * @param JobInstance   $job
     *
     * @return JobExecution
     */
    public function createJobExecution(JobInstance $job)
    {
        return new JobExecution();
    }

    /**
     * Update a JobExecution
     *
     * @param JobExecution $jobExecution
     *
     * @return JobExecution
     */
    public function updateJobExecution(JobExecution $jobExecution)
    {
    }

    /**
     * Update a StepExecution
     *
     * @param StepExecution $stepExecution
     *
     * @return StepExecution
     */
    public function updateStepExecution(StepExecution $stepExecution)
    {
    }
}
