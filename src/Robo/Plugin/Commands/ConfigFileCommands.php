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
        $this->generateConfig('behat.yml.dist', 'behat.yml');
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
        $this->generateConfig('drush/drush.yml.dist', 'drush/drush.yml');
    }

    /**
     * Generates a configuration file.
     *
     * This will copy the source file to the destination file and replace any
     * environment variables in it, as long as they are declared as
     * `${ENV_VAR}`. If the destination file exists it will be overwritten.
     *
     * @param string $source
     *   The path to the source file, relative to the project root.
     * @param string $destination
     *   The path to the destination file, relative to the project root.
     */
    protected function generateConfig(string $source, string $destination): void
    {
        $replace = [];

        foreach (array_keys($_SERVER) as $env_var) {
            $value = $_SERVER[$env_var];
            if (is_scalar($value)) {
                $replace['${' . $env_var . '}'] = $value;
            }
        }

        $this->taskFilesystemStack()
          ->copy($source, $destination, true)
          ->run();

        $this->taskReplaceInFile($destination)
          ->from(array_keys($replace))
          ->to(array_values($replace))
          ->run();
    }

}
