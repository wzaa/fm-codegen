<?php
namespace App\Command;

use App\CodeGenerator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class GenerateCodes extends Command
{
    /** @var int */
    private $numberOfCodes;

    /** @var int */
    private $lengthOfCode;

    /** @var ?string */
    private $file;

    const ALPHABET = '';

    public function configure()
    {
        $this
            ->setName('fm:generate-codes')
            ->setDescription('Generate unique discount codes.')
            ->addOption('numberOfCodes', 'c', InputOption::VALUE_REQUIRED, 'How many codes to generate')
            ->addOption('lengthOfCode', 'l', InputOption::VALUE_REQUIRED, 'How long the codes should be')
            ->addOption('file', 'o', InputOption::VALUE_OPTIONAL, 'File to output codes to (default is stdout)')
            ;
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->numberOfCodes = (int)$input->getOption('numberOfCodes');
        $this->lengthOfCode = (int)$input->getOption('lengthOfCode');
        $this->file = $input->getOption('file');

        if (!$this->numberOfCodes) {
            throw new \InvalidArgumentException('Number of codes is required and must be a number.');
        }

        if (!$this->lengthOfCode) {
            throw new \InvalidArgumentException('Length of code is required and must be a number.');
        }

        if ($this->file && file_exists($this->file)) {
            throw new \InvalidArgumentException('Output file already exists.');
        }
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $generator = new CodeGenerator($this->lengthOfCode);

        $codes = $generator->generate($this->numberOfCodes);

        if ($this->file) {
            $text = implode("\r\n", $codes) . "\r\n";

            file_put_contents($this->file, $text);
        } else {
            foreach ($codes as $code) {
                $output->writeln($code);
            }
        }
    }
}
