<?php

declare(strict_types = 1);

namespace CodeLab\RoboDrupalSetup\Robo\Plugin\Commands;

use CodeLab\RoboDrupalSetup\Robo\Task\Tasks;

class ConfigFileCommands extends \Robo\Tasks
{

    use Tasks;

    /**
     * Generates the behat.yml configuration file.
     *
     * The `behat.yml.dist` file will be copied to `behat.yml` and the
     * environment variables in it will be replaced.
     *
     * @command behat:generate-config
     */
    public function behatGenerateConfig(): void
    {
        $this->taskGenerateConfig('behat.yml.dist', 'behat.yml')->run();
    }

    /**
     * Generates the drush.yml configuration file.
     *
     * The `drush.yml.dist` file will be copied to `drush.yml` and the
     * environment' variables in it will be replaced.
     *
     * @command drush:generate-config
     */
    public function drushGenerateConfig(): void
    {
        $this->taskGenerateConfig('drush/drush.yml.dist', 'drush/drush.yml')->run();
    }

}
