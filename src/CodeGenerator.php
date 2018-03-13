<?php
namespace App;

class CodeGenerator
{
    const ALPHABET = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

    /** @var int */
    private $lengthOfCode;

    public function __construct(
        int $lengthOfCode
    )
    {
        $this->lengthOfCode = $lengthOfCode;
    }

    private static function assertNotOverLimit(int $numberOfCodes, int $lengthOfCode)
    {
        $maxCodes = pow(strlen(self::ALPHABET), $lengthOfCode);

        if ($maxCodes < $numberOfCodes) {
            throw new \InvalidArgumentException('It\'s only possible to generate up to '
                . $maxCodes . ' codes of length ' . $lengthOfCode
                . ', but requested ' . $numberOfCodes);
        }
    }

    public function generate(int $numberOfCodes): array
    {
        self::assertNotOverLimit($numberOfCodes, $this->lengthOfCode);

        $codes = [];

        while (count($codes) < $numberOfCodes) {
            $code = $this->generateOne();

            $codes[$code] = 1;
        }

        return array_keys($codes);
    }

    public function generateOne(): string
    {
        $chars = [];

        $maxRand = strlen(self::ALPHABET) - 1;

        for ($i = 0; $i < $this->lengthOfCode; $i++) {
            $chars[] = self::ALPHABET[rand(0, $maxRand)];
        }

        return join($chars);
    }
}
