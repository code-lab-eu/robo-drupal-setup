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
        // @todo This is duplicating code from ConfigFileCommands. Call the
        //   commands directly once there is a way to instantiate the command
        //   class.
        // @see https://github.com/consolidation/Robo/pull/675
        $this->taskGenerateConfig('behat.yml.dist', 'behat.yml')->run();
        $this->taskGenerateConfig('drush/drush.yml.dist', 'drush/drush.yml')->run();
    }

}
