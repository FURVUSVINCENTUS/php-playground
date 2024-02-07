<?php

namespace Amp\Dns;

use Amp\WindowsRegistry\KeyNotFoundException;
use Amp\WindowsRegistry\WindowsRegistry;

final class WindowsConfigLoader implements ConfigLoader
{
    private HostLoader $hostLoader;

    public function __construct(HostLoader $hostLoader = null)
    {
        $this->hostLoader = $hostLoader ?? new HostLoader;
    }

    public function loadConfig(): Config
    {
        $keys = [
            "HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Services\\Tcpip\\Parameters\\NameServer",
            "HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Services\\Tcpip\\Parameters\\DhcpNameServer",
        ];

        $reader = new WindowsRegistry;
        $nameserver = "";

        while ($nameserver === "" && ($key = \array_shift($keys))) {
            try {
                $nameserver = $reader->read($key) ?? '';
            } catch (KeyNotFoundException) {
                // retry other possible locations
            }
        }

        if ($nameserver === "") {
            $interfaces = "HKEY_LOCAL_MACHINE\\SYSTEM\\CurrentControlSet\\Services\\Tcpip\\Parameters\\Interfaces";
            $subKeys = $reader->listKeys($interfaces);

            foreach ($subKeys as $key) {
                foreach (["NameServer", "DhcpNameServer"] as $property) {
                    try {
                        $nameserver = $reader->read("{$key}\\{$property}") ?? '';

                        if ($nameserver !== "") {
                            break 2;
                        }
                    } catch (KeyNotFoundException) {
                        // retry other possible locations
                    }
                }
            }
        }

        if ($nameserver === "") {
            throw new ConfigException("Could not find a nameserver in the Windows Registry");
        }

        $nameservers = [];

        // Microsoft documents space as delimiter, AppVeyor uses comma, we just accept both
        foreach (\explode(" ", \strtr($nameserver, ",", " ")) as $nameserver) {
            $nameserver = \trim($nameserver);
            $ip = @\inet_pton($nameserver);

            if ($ip === false) {
                continue;
            }

            if (isset($ip[15])) { // IPv6
                $nameservers[] = "[" . $nameserver . "]:53";
            } else { // IPv4
                $nameservers[] = $nameserver . ":53";
            }
        }

        $hosts = $this->hostLoader->loadHosts();

        return new Config($nameservers, $hosts);
    }
}
