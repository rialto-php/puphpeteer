# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

**Note:** PuPHPeteer is heavily based on [Rialto](https://github.com/nesk/rialto). For a complete overview of the changes, you might want to check out [Rialto's changelog](https://github.com/nesk/rialto/blob/master/CHANGELOG.md) too.

## [Unreleased]
_In progress…_

## [2.0.0] - 2020-12-01
### Added
- Support Puppeteer v5.5
- Support PHP 8
- Add documentation on all resources to provide autocompletion in IDEs

### Removed
- Drop support for PHP 7.1 and 7.2

## [1.6.0] - 2019-07-01
### Added
- Support Puppeteer v1.18

## [1.5.0] - 2019-03-17
### Added
- Support Puppeteer v1.13
- Make the `ElementHandle` resource extend the `JSHandle` one

### Fixed
- Add missing `Accessibility` resource

## [1.4.1] - 2018-11-27
### Added
- Support Puppeteer v1.10

## [1.4.0] - 2018-09-22
### Added
- Support Puppeteer v1.8

### Changed
- Detect resource types by using the constructor name

### Fixed
- Logs of initial pages are now retrieved

## [1.3.0] - 2018-08-20
### Added
- Add a `log_browser_console` option to log the output of Browser's console methods (`console.log`, `console.debug`, `console.table`, etc…) to the PHP logger
- Support Puppeteer v1.7

## [1.2.0] - 2018-07-25
### Added
- Support Puppeteer v1.6

### Changed
- Upgrade to Rialto v1.1

## [1.1.0] - 2018-06-12
### Added
- Support Puppeteer v1.5
- Add aliases for evaluation methods to the `ElementHandle` resource
- Support new Puppeteer v1.5 resources:
    - `BrowserContext`
    - `Worker`

### Fixed
- Fix Travis tests

## [1.0.0] - 2018-06-05
### Changed
- Change PHP's vendor name from `extractr-io` to `nesk`
- Change NPM's scope name from `@extractr-io` to `@nesk`
- Upgrade to Rialto v1

## [0.2.2] - 2018-04-20
### Added
- Support Puppeteer v1.3
- Test missing Puppeteer resources: `ConsoleMessage` and `Dialog`
- Show a warning in logs if Puppeteer's version doesn't match requirements

## [0.2.1] - 2018-04-09
### Changed
- Update Rialto version requirements

## [0.2.0] - 2018-02-19
### Added
- Support new Puppeteer v1.1 resources:
    - `BrowserFetcher`
    - `CDPSession`
    - `Coverage`
    - `SecurityDetails`
- Test Puppeteer resources
- Support PHPUnit v7
- Add Travis integration

### Changed
- Lock Puppeteer's version to v1.1 to avoid issues with forward compatibility

## 0.1.0 - 2018-01-29
First release


[Unreleased]: https://github.com/nesk/puphpeteer/compare/2.0.0...HEAD
[2.0.0]: https://github.com/nesk/puphpeteer/compare/1.6.0...2.0.0
[1.6.0]: https://github.com/nesk/puphpeteer/compare/1.5.0...1.6.0
[1.5.0]: https://github.com/nesk/puphpeteer/compare/1.4.1...1.5.0
[1.4.1]: https://github.com/nesk/puphpeteer/compare/1.4.0...1.4.1
[1.4.0]: https://github.com/nesk/puphpeteer/compare/1.3.0...1.4.0
[1.3.0]: https://github.com/nesk/puphpeteer/compare/1.2.0...1.3.0
[1.2.0]: https://github.com/nesk/puphpeteer/compare/1.1.0...1.2.0
[1.1.0]: https://github.com/nesk/puphpeteer/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/nesk/puphpeteer/compare/0.2.2...1.0.0
[0.2.2]: https://github.com/nesk/puphpeteer/compare/0.2.1...0.2.2
[0.2.1]: https://github.com/nesk/puphpeteer/compare/0.2.0...0.2.1
[0.2.0]: https://github.com/nesk/puphpeteer/compare/0.1.0...0.2.0
