<?php
namespace michaelszymczak\CheckCheckIn\Test\Utils\Filter;

use \michaelszymczak\CheckCheckIn\Utils\Filter\Filter;
/**
 * @covers \michaelszymczak\CheckCheckIn\Utils\Filter\Filter
 *
 */
class FilterShould extends \PHPUnit_Framework_TestCase
{
    private $input = array(
        'app/foo/bar/pre-commit.php',
        'src/foo/bar/Baz.php',
        'src/foo/bar/baz.js',
        'src/foo/bar/baz.js',
        'app/foo/bar.js',
        'app/foo/bar.php',
    );

    public function setUp()
    {

    }

    /**
     * @test
     */
    public function returnOnlyPathsMatchingGivenExtension()
    {
        $filter = new Filter(array(Filter::PHP));

        $this->assertSame(

            array(
            'app/foo/bar/pre-commit.php',
            'src/foo/bar/Baz.php',
            'app/foo/bar.php',
            ),

            $filter->filter($this->input)
        );
    }
    /**
     * @test
     */
    public function returnUniquePathsOnly()
    {
        $filter = new Filter(array(Filter::JS));

        $this->assertSame(

            array(
                'src/foo/bar/baz.js',
                'app/foo/bar.js'
            ),

            $filter->filter($this->input)
        );
    }
    /**
     * @test
     */
    public function returnSumOfPathsMatchingAnyOfGivenPatterns()
    {
        $filter = new Filter(array(Filter::JS, Filter::PHP));

        $this->assertSame(

            array(
                'app/foo/bar/pre-commit.php',
                'src/foo/bar/Baz.php',
                'src/foo/bar/baz.js',
                'app/foo/bar.js',
                'app/foo/bar.php',
            ),

            $filter->filter($this->input)
        );
    }
    /**
     * @test
     */
    public function returnPathsMatchingGivenCustomPattern()
    {
        $filter = new Filter(array('#^app/foo/bar#'));

        $this->assertSame(

            array(
                'app/foo/bar/pre-commit.php',
                'app/foo/bar.js',
                'app/foo/bar.php',
            ),

            $filter->filter($this->input)
        );
    }
    /**
     * @test
     */
    public function returnUniquePathsOnlyDespiteThatSomeAppliesToMoreThanOnePattern()
    {
        $filter = new Filter(array('/baz\.js$/', Filter::JS));

        $this->assertSame(

            array(
                'src/foo/bar/baz.js',
                'app/foo/bar.js'
            ),

            $filter->filter($this->input)
        );
    }
    /**
     * @test
     */
    public function returnPathsWithoutBlacklistedOnes()
    {
        $filter = new Filter(array(Filter::JS), array('/baz\.js$/'));

        $this->assertSame(

            array(
                'app/foo/bar.js'
            ),

            $filter->filter($this->input)
        );
    }

}
