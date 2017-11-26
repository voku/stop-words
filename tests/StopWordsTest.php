<?php

use voku\helper\StopWords;

/**
 * Class PhoneticAlgorithmsTest
 */
class StopWordsTest extends \PHPUnit\Framework\TestCase
{
  public function testForGermanStopWords()
  {
    $stopWords = new StopWords();
    $testStrings = [
        'für',
        'haben',
        'hier',
        'ich',
    ];

    foreach ($testStrings as $testString) {
      self::assertTrue(
          in_array($testString, $stopWords->getStopWordsFromLanguage('de'), true),
          'tested: ' . $testString
      );
    }
  }

  public function testForAllStopWords()
  {
    $stopWords = new StopWords();
    $testStrings = [
        'a',
        'ahogy',
        'ahol',
        'aki',
        'akik',
        'akkor',
    ];

    $result = $stopWords->getStopWordsAll();

    foreach ($testStrings as $testString) {
      self::assertTrue(
          in_array($testString, $result['hu'], true),
          'tested: ' . $testString
      );
    }
  }

  /**
   * @expectedException \voku\helper\StopWordsLanguageNotExists
   */
  public function testForNonExistingLanguage()
  {
    $stopWords = new StopWords();
    $stopWords->getStopWordsFromLanguage('foo');
  }
}
