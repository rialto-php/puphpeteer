# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- Support Puppeteer v1.6

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


[Unreleased]: https://github.com/nesk/puphpeteer/compare/1.1.0...HEAD
[1.1.0]: https://github.com/nesk/puphpeteer/compare/1.0.0...1.1.0
[1.0.0]: https://github.com/nesk/puphpeteer/compare/0.2.2...1.0.0
[0.2.2]: https://github.com/nesk/puphpeteer/compare/0.2.1...0.2.2
[0.2.1]: https://github.com/nesk/puphpeteer/compare/0.2.0...0.2.1
[0.2.0]: https://github.com/nesk/puphpeteer/compare/0.1.0...0.2.0
