# Changelog

## 0.5.0 (2018-06-25)

* Improve documentation by describing what is expected of a class implementing `CacheInterface`. 
  (#21, #22, #23, #27 by @WyriHaximus)

* Implemented (optional) Least Recently Used (LRU) cache algorithm for `ArrayCache`. 
  (#26 by @clue)

* Added support for cache expiration (TTL).
  (#29 by @clue and @WyriHaximus)

* Renamed `remove` to `delete` making it more in line with `PSR-16`. 
  (#30 by @clue)

## 0.4.2 (2017-12-20)

*   Improve documentation with usage and installation instructions
    (#10 by @clue)

*   Improve test suite by adding PHPUnit to `require-dev` and
    add forward compatibility with PHPUnit 5 and PHPUnit 6 and
    sanitize Composer autoload paths
    (#14 by @shaunbramley and #12 and #18 by @clue)

## 0.4.1 (2016-02-25)

* Repository maintenance, split off from main repo, improve test suite and documentation
* First class support for PHP7 and HHVM (#9 by @clue)
* Adjust compatibility to 5.3 (#7 by @clue)

## 0.4.0 (2014-02-02)

* BC break: Bump minimum PHP version to PHP 5.4, remove 5.3 specific hacks
* BC break: Update to React/Promise 2.0
* Dependency: Autoloading and filesystem structure now PSR-4 instead of PSR-0

## 0.3.2 (2013-05-10)

* Version bump

## 0.3.0 (2013-04-14)

* Version bump

## 0.2.6 (2012-12-26)

* Feature: New cache component, used by DNS
