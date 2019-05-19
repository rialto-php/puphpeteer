<?php

namespace Nesk\Puphpeteer\Support;

use Psr\Log\LoggerInterface;
use vierbergenlars\SemVer\expression as SemVerExpression;
use vierbergenlars\SemVer\SemVerException;
use vierbergenlars\SemVer\version as SemVerVersion;

class Version
{
    /**
     * @var string
     */
    protected $npmManifestPath;

    /**
     * @var string
     */
    protected $workingDirectory = __DIR__;

    public function __construct(string $npmManifestPath, string $workingDirectory = __DIR__)
    {
        $this->npmManifestPath = $npmManifestPath;
        $this->workingDirectory = $workingDirectory;
    }

    public function logUnexpectedPuppeteerVersion(LoggerInterface $logger): void {
        $currentVersion = $this->currentPuppeteerVersion();
        $acceptedVersions = $this->acceptedPuppeteerVersion();

        try {
            $semver = new SemVerVersion($currentVersion);
            $expression = new SemVerExpression($acceptedVersions);

            if (!$semver->satisfies($expression)) {
                $logger->warning(
                    "The installed version of Puppeteer (v$currentVersion) doesn't match the requirements"
                    ." ($acceptedVersions), you may encounter issues."
                );
            }
        } catch (SemVerException $exception) {
            $logger->error("Puppeteer doesn't seem to be installed.");
        }
    }

    public function currentPuppeteerVersion(): string {
        $currentDir = $this->workingDirectory;
        while (!is_file("$currentDir/node_modules/puppeteer/package.json") && dirname($currentDir) !== $currentDir) {
            $currentDir = dirname($currentDir);
        }

        if (is_file($filePath = "$currentDir/node_modules/puppeteer/package.json")) {
            $version = json_decode(file_get_contents($filePath))->version ?? null;
            if (is_string($version)) {
                return $version;
            }
        }

        throw new \RuntimeException("Puppeteer doesn't seem to be installed.");
    }

    protected function acceptedPuppeteerVersion(): string {
        $npmManifest = json_decode(file_get_contents($this->npmManifestPath));

        return $npmManifest->dependencies->puppeteer;
    }
}
