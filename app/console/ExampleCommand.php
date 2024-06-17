<?php

namespace App\Console;

use Aloe\Command;

class ExampleCommand extends Command
{
    /**
     * The default name of the command.
     *
     * @var string
     */
    protected static $defaultName = 'example';

    /**
     * The description of the command.
     *
     * @var string
     */
    public $description = "example command's description";

    /**
     * The help text for the command.
     *
     * @var string
     */
    public $help = "example command's help";

    /**
     * Configure the command options and arguments.
     *
     * This method is used to set up the arguments and options
     * that the command accepts.
     *
     * @return void
     */
    protected function config()
    {
        $this
            ->setArgument('argument', 'optional', 'argument description')
            ->setOption('option', 'o', 'required', 'option description');
    }

    /**
     * Handle the command execution.
     *
     * This method contains the logic that is executed when the command
     * is run. It prints a comment with the argument and option values.
     *
     * @return integer The exit code of the command
     */
    protected function handle()
    {
        $this->comment(
            sprintf(
                "example command's output %s %s",
                $this->argument('argument'),
                $this->option('option')
            )
        );

        return 0;
    }
}
