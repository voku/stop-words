<?php

namespace voku\helper;

/**
 * Phonetic-Helper-Class
 *
 * @package voku\helper
 */
final class StopWords
{
  /**
   * @var array
   */
  private static $availableLanguages = array(
      'ar',
      'bg',
      'ca',
      'cz',
      'da',
      'de',
      'el',
      'en',
      'eo',
      'es',
      'et',
      'fi',
      'fr',
      'hi',
      'hr',
      'hu',
      'id',
      'it',
      'ka',
      'lt',
      'lv',
      'nl',
      'no',
      'pl',
      'pt',
      'ro',
      'ru',
      'sk',
      'sv',
      'tr',
      'uk',
      'vi'
  );

  /**
   * @var array
   */
  private $stopWords = array();

  /**
   * Load language-data from one language.
   *
   * @param string $language
   *
   * @throws StopWordsLanguageNotExists
   */
  private function loadLanguageData($language = 'de')
  {
    if (in_array($language, self::$availableLanguages, true) === false) {
      throw new StopWordsLanguageNotExists('language not supported: ' . $language);
    }

    $this->stopWords[$language] = $this->getData($language);
  }

  /**
   * Get data from "/data/*.php".
   *
   * @param string $file
   *
   * @return array <p>Will return an empty array on error.</p>
   */
  private function getData($file)
  {
    static $RESULT_STOP_WORDS_CACHE = array();

    if (isset($RESULT_STOP_WORDS_CACHE[$file])) {
      return $RESULT_STOP_WORDS_CACHE[$file];
    }

    $file = __DIR__ . '/stopwords/' . $file . '.php';
    if (file_exists($file)) {
      /** @noinspection PhpIncludeInspection */
      $RESULT_STOP_WORDS_CACHE[$file] = require $file;
    } else {
      $RESULT_STOP_WORDS_CACHE[$file] = array();
    }

    return $RESULT_STOP_WORDS_CACHE[$file];
  }

  /**
   * Get the stop-words from one language.
   *
   * @param string $language
   *
   * @return array
   *
   * @throws StopWordsLanguageNotExists
   */
  public function getStopWordsFromLanguage($language = 'de')
  {
    if (in_array($language, self::$availableLanguages, true) === false) {
      throw new StopWordsLanguageNotExists('language not supported: ' . $language);
    }

    if (!isset($this->stopWords[$language])) {
      $this->loadLanguageData($language);
    }

    return $this->stopWords[$language];
  }

  private function loadLanguageDataAll()
  {
    foreach (self::$availableLanguages as $language) {
      if (!isset($this->stopWords[$language])) {
        $this->loadLanguageData($language);
      }
    }
  }

  /**
   * Get all stop-words from all languages.
   *
   * @return array
   *
   * @throws StopWordsLanguageNotExists
   */
  public function getStopWordsAll()
  {
    $this->loadLanguageDataAll();

    return $this->stopWords;
  }
}
