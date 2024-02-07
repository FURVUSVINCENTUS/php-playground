<?php

namespace Amp\Dns;

final class Config
{
    private array $nameservers;

    private array $knownHosts;

    private float $timeout;

    private int $attempts;

    private array $searchList = [];

    private int $ndots = 1;

    private bool $rotation = false;

    /**
     * @throws ConfigException
     */
    public function __construct(array $nameservers, array $knownHosts = [], float $timeout = 3, int $attempts = 2)
    {
        if (\count($nameservers) < 1) {
            throw new ConfigException("At least one nameserver is required for a valid config");
        }

        foreach ($nameservers as $nameserver) {
            $this->validateNameserver($nameserver);
        }

        if ($timeout < 0) {
            throw new ConfigException("Invalid timeout ($timeout), must be 0 or greater");
        }

        if ($attempts < 1) {
            throw new ConfigException("Invalid attempt count ($attempts), must be 1 or greater");
        }

        // Windows does not include localhost in its host file. Fetch it from the system instead
        if (!isset($knownHosts[Record::A]["localhost"]) && !isset($knownHosts[Record::AAAA]["localhost"])) {
            // PHP currently provides no way to **resolve** IPv6 hostnames (not even with fallback)
            $local = \gethostbyname("localhost");
            if ($local !== "localhost") {
                $knownHosts[Record::A]["localhost"] = $local;
            } else {
                $knownHosts[Record::AAAA]["localhost"] = '::1';
            }
        }

        $this->nameservers = $nameservers;
        $this->knownHosts = $knownHosts;
        $this->timeout = $timeout;
        $this->attempts = $attempts;
    }

    public function withSearchList(array $searchList): self
    {
        $self = clone $this;
        $self->searchList = $searchList;

        return $self;
    }

    /**
     * @throws ConfigException
     */
    public function withNdots(int $ndots): self
    {
        if ($ndots < 0) {
            throw new ConfigException("Invalid ndots ($ndots), must be greater or equal to 0");
        }
        if ($ndots > 15) {
            $ndots = 15;
        }
        $self = clone $this;
        $self->ndots = $ndots;

        return $self;
    }

    public function withRotationEnabled(bool $enabled = true): self
    {
        $self = clone $this;
        $self->rotation = $enabled;

        return $self;
    }

    public function getNameservers(): array
    {
        return $this->nameservers;
    }

    public function getKnownHosts(): array
    {
        return $this->knownHosts;
    }

    public function getTimeout(): float
    {
        return $this->timeout;
    }

    public function getAttempts(): int
    {
        return $this->attempts;
    }

    public function getSearchList(): array
    {
        return $this->searchList;
    }

    public function getNdots(): int
    {
        return $this->ndots;
    }

    public function isRotationEnabled(): bool
    {
        return $this->rotation;
    }

    /**
     * @throws ConfigException
     */
    private function validateNameserver(string $nameserver): void
    {
        if ($nameserver[0] === "[") { // IPv6
            $addr = \strstr(\substr($nameserver, 1), "]", true);
            $addrEnd = \strrpos($nameserver, "]");
            if ($addrEnd === false) {
                throw new ConfigException("Invalid nameserver: $nameserver");
            }

            $port = \substr($nameserver, $addrEnd + 1);

            if ($port !== "" && !\preg_match("(^:(\\d+)$)", $port)) {
                throw new ConfigException("Invalid nameserver: $nameserver");
            }

            $port = $port === "" ? 53 : \substr($port, 1);
        } else { // IPv4
            $arr = \explode(":", $nameserver, 2);

            if (\count($arr) === 2) {
                [$addr, $port] = $arr;
            } else {
                $addr = $arr[0];
                $port = 53;
            }
        }

        $addr = \trim($addr, "[]");
        $port = (int) $port;

        if (!@\inet_pton($addr)) {
            throw new ConfigException("Invalid server IP: $addr");
        }

        if ($port < 1 || $port > 65535) {
            throw new ConfigException("Invalid server port: $port");
        }
    }
}
