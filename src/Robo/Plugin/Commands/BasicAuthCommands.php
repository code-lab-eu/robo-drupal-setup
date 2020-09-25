<?php

declare(strict_types = 1);

namespace CodeLab\RoboDrupalSetup\Robo\Plugin\Commands;

use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Robo\Tasks;

class BasicAuthCommands extends Tasks implements LoggerAwareInterface
{

    use LoggerAwareTrait;

    /**
     * Enables or disables HTTP Basic Authentication.
     *
     * This command will enable HTTP Basic Authentication if the credentials are
     * set in the environment variables BASIC_AUTH_USERNAME and
     * BASIC_AUTH_PASSWORD.
     *
     * If either of these variables are not set basic authentication will be
     * disabled.
     *
     * Make sure to run this every time after scaffolding Drupal core.
     *
     * @command environment:setup-basic-auth
     */
    public function environmentSetupBasicAuth(): void {
        // Remove the existing .htpasswd file.
        $this->taskFilesystemStack()->remove('web/.htpasswd')->run();

        // Remove the basic auth directive from the .htaccess file if it exists.
        $this->taskReplaceInFile('web/.htaccess')
          ->regex('/^AuthType Basic\n.*\n.*\nRequire valid-user\n/m')
          ->to('')
          ->run();

        // Check that the basic authentication credentials are defined.
        foreach (['BASIC_AUTH_USERNAME', 'BASIC_AUTH_PASSWORD'] as $env_var) {
            if (empty($_SERVER[$env_var])) {
                $this->logger->notice('Basic authentication has been disabled since the credentials are not set.');
                return;
            }
        }

        // Generate a fresh .htpasswd file.
        $result = $this->taskExec('htpasswd')
          ->option('-b') // Provide the password as an argument.
          ->option('-c') // Create a new file.
          ->arg('web/.htpasswd')
          ->arg($_SERVER['BASIC_AUTH_USERNAME'])
          ->arg($_SERVER['BASIC_AUTH_PASSWORD'])
          ->run();

        if (!$result->wasSuccessful()) {
            $this->logger->error('.htpasswd file could not be written');
        }

        // Add the directive to enable basic authentication.
        $htpasswd_path = getcwd() . '/web/.htpasswd';
        $this->taskWriteToFile('web/.htaccess')
          ->append()
          ->lines([
                    'AuthType Basic',
                    'AuthName "Restricted access"',
                    'AuthUserFile ' . $htpasswd_path,
                    'Require valid-user',
                  ])
          ->run();
    }

}
