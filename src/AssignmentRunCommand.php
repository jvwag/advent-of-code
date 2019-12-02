<?php
declare(strict_types=1);

namespace jvwag\AdventOfCode;

use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AssignmentRunCommand
 *
 * @package jvwag\AdventOfCode
 */
class AssignmentRunCommand extends Command
{
    private const MIN_YEAR = 2015;
    private const MAX_YEAR = 2050;

    public const COMMAND_NAME = "run";

    private AssignmentFactory $assignment_factory;

    public function __construct(AssignmentFactory $assignment_factory)
    {
        parent::__construct(null);
        $this->assignment_factory = $assignment_factory;
    }


    public function configure(): void
    {
        $this->setName(self::COMMAND_NAME)
            ->setDescription('Runs assignment')
            ->setHelp("This command runs a given assignment")
            ->addArgument("day", InputArgument::REQUIRED, "Day of the assignment")
            ->addOption("year", null, InputOption::VALUE_REQUIRED, "Year of the assignment", date("Y"));
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return int Exit code
     * @throws InvalidArgumentException
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $year = $this->validateYear($input->getOption("year"));
        $day = $input->getArgument("day");

        try {
            $assignment = $this->assignment_factory->create($year, $day);
            $answers = $assignment->run();

            foreach ([1, 2] as $part) {
                if (isset($answers[$part - 1])) {
                    $output->write(sprintf("Answer day %s of %d, part %d:\n%s\n", $day, $year, $part, $answers[$part - 1]));
                }
            }
        } catch (Exception $e) {
            $output->write("error: " . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Validate the year of the advent calendar to be an integer within bounds of MIN_YEAR and MAX_YEAR
     *
     * @param $year string Year of the advent calendar
     *
     * @return int Validated year
     * @throws InvalidArgumentException If the year is invalid of out of bounds
     */
    private function validateYear(string $year): int
    {
        $value = filter_var(
            $year,
            FILTER_VALIDATE_INT,
            [
                "options" => ["min_range" => self::MIN_YEAR, "max_range" => self::MAX_YEAR],
                "flags" => FILTER_FLAG_ALLOW_HEX | FILTER_FLAG_ALLOW_OCTAL,
            ]);

        if ($value === false) {
            throw new InvalidArgumentException(sprintf("Year must be an integer in range of %d to %d", self::MIN_YEAR, self::MAX_YEAR));
        }

        return (int)$value;
    }
}
