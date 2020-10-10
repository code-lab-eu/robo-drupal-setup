<?php

declare(strict_types = 1);

namespace CodeLab\RoboDrupalSetup\Robo\Task;

use Robo\Common\BuilderAwareTrait;
use Robo\Contract\BuilderAwareInterface;
use Robo\Contract\TaskInterface;
use Robo\Result;

/**
 * Generates a config file by replacing placeholders wih environment variables.
 */
class GenerateConfig implements TaskInterface, BuilderAwareInterface
{

    use BuilderAwareTrait;

    /**
     * The path to the source file, relative to the project root.
     *
     * @var string
     */
    protected $source;

    /**
     * The path to the destination file, relative to the project root.
     *
     * @var string
     */
    protected $destination;

    /**
     * Constructs a GenerateConfig task.
     */
    public function __construct(string $source, string $destination)
    {
        $this->source = $source;
        $this->destination = $destination;
    }

    /**
     * @inheritDoc
     */
    public function run(): Result
    {
        $replace = [];

        foreach (array_keys($_SERVER) as $env_var) {
            $value = $_SERVER[$env_var];
            if (is_scalar($value)) {
                $replace['${' . $env_var . '}'] = $value;
            }
        }

        $collection = $this->collectionBuilder();
        $collection->taskFilesystemStack()
          ->copy($this->source, $this->destination, true);

        $collection->taskReplaceInFile($this->destination)
          ->from(array_keys($replace))
          ->to(array_values($replace));

        return $collection->run();
    }

}
