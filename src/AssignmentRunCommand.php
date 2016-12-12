<?php

namespace jvwag\AdventOfCode;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class AssignmentRunCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('run')
            ->setDescription('Runs assignment')
            ->setHelp("This command runs a given assignment")
            ->addArgument("day", null, "Day of the assignment")
            ->addOption("year", null, InputOption::VALUE_OPTIONAL, "Year of the assignment", "2016");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getOption("year");
        $day = $input->getArgument("day");

        /** @var AssignmentInterface $day */
        $day = $this->container->get("assignment_factory")->create($year, $day);
        $day->run();
    }
}
