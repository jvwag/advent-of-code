<?php

namespace jvwag\AdventOfCode;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AssignmentRunCommand
 *
 * @package jvwag\AdventOfCode
 */
class AssignmentRunCommand extends ContainerAwareCommand
{
    protected function configure(): void
    {
        $this->setName('run')
            ->setDescription('Runs assignment')
            ->setHelp("This command runs a given assignment")
            ->addArgument("day", InputArgument::REQUIRED, "Day of the assignment")
            ->addOption("year", null, InputOption::VALUE_REQUIRED, "Year of the assignment", date("Y"));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int|null|void
     * @throws \Symfony\Component\Console\Exception\InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $year = $input->getOption("year");
        $day = $input->getArgument("day");

        try {
            /** @var AssignmentFactory $assignment_factory */
            $assignment_factory = $this->container->get("assignment_factory");
            $assignment = $assignment_factory->create($year, $day);
            $answers = $assignment->run();

            foreach ([1, 2] as $part) {
                $output->write(sprintf("Answer day %d of %d, part %d:\n%s\n", $day, $year, $part, $answers[$part - 1]));
            }
        } catch (\Exception $e) {
            $output->write("error: ".$e->getMessage());
        }
    }
}
