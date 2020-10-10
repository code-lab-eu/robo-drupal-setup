<?php

declare(strict_types = 1);

namespace CodeLab\RoboDrupalSetup\Robo\Task;

use Robo\Contract\TaskInterface;

/**
 * Functions to load tasks.
 */
trait Tasks
{

    /**
     * Returns a task to generate a configuration file.
     *
     * This will copy the source file to the destination file and replace any
     * environment variables in it, as long as they are declared as
     * `${ENV_VAR}`. If the destination file exists it will be overwritten.
     *
     * @param string $source
     *   The path to the source file, relative to the project root.
     * @param string $destination
     *   The path to the destination file, relative to the project root.
     *
     * @return \CodeLab\RoboDrupalSetup\Robo\Task\GenerateConfig
     *   The task.
     */
    protected function taskGenerateConfig(string $source, string $destination): TaskInterface
    {
        return $this->task(GenerateConfig::class, $source, $destination);
    }

}
