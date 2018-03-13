<?php
namespace Tests;

use App\CodeGenerator;
use PHPUnit\Framework\TestCase;

class CodeGeneratorTest extends TestCase
{
    /** @doesNotPerformAssertions */
    public function testCreating()
    {
        new CodeGenerator(1);
    }

    /**
     * @testWith [3]
     *           [5]
     *           [10]
     */
    public function testGenerateSingleCode(int $lengthOfCode)
    {
        $generator = new CodeGenerator($lengthOfCode);
        $alphabet = str_split(CodeGenerator::ALPHABET);

        for ($i = 0; $i < 100; $i++) {
            $code = $generator->generateOne();

            $split = str_split($code);

            self::assertCount($lengthOfCode, $split);

            $charsNotInAlphabet = array_diff($split, $alphabet);
            self::assertEquals([], $charsNotInAlphabet, 'Code contains characters not from the alphabet');
        }
    }

    /**
     * @testWith [30, 3]
     *           [15, 6]
     *           [5, 10]
     */
    public function testGenerateCodes(int $numberOfCodes, int $lengthOfCode)
    {
        $generator = new CodeGenerator($lengthOfCode);
        $alphabet = str_split(CodeGenerator::ALPHABET);

        for ($i = 0; $i < 10; $i++) {
            $codes = $generator->generate($numberOfCodes);

            self::assertCount($numberOfCodes, $codes);

            foreach ($codes as $code) {
                $split = str_split($code);

                $charsNotInAlphabet = array_diff($split, $alphabet);
                self::assertEquals([], $charsNotInAlphabet, 'Code contains characters not from the alphabet');
            }
        }
    }

    public function testGenerateCodesForUniques()
    {
        $generator = new CodeGenerator(2);

        for ($i = 0; $i < 10; $i++) {
            $codes = $generator->generate(3000);

            $uniques = array_unique($codes);
            self::assertCount(3000, $uniques);
        }
    }

    /**
     * @testWith [1, 100]
     *           [2, 4000]
     *           [3, 250000]
     */
    public function testGenerateCodesWhenOverLimit(int $length, int $howMany)
    {
        $generator = new CodeGenerator($length);

        self::expectException(\InvalidArgumentException::class);

        $generator->generate($howMany);
    }
}
