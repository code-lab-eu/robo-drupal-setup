<?php

declare(strict_types = 1);

namespace CodeLab\RoboDrupalSetup\Robo\Plugin\Commands;

use CodeLab\RoboDrupalSetup\Robo\Task\Tasks;
use Robo\Robo;

class DevelopmentCommands extends \Robo\Tasks
{

    use Tasks;

    /**
     * Sets up a development environment.
     *
     * @command dev:setup
     */
    public function devSetup(): void
    {
        /** @var \CodeLab\RoboDrupalSetup\Robo\Plugin\Commands\ConfigFileCommands $config_file_commands */
        $config_file_commands = Robo::getCommandInstance('ConfigFile');
        $config_file_commands->behatGenerateConfig();
        $config_file_commands->drushGenerateConfig();
    }

}
