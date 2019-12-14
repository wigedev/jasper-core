<?php
namespace WigeDev\JasperCore\Utility;

use WigeDev\JasperCore\Core;

/**
 * Class Configuration
 *
 * The configuration class manages the configuration settings for the application, providing parsing of the config files
 * in a specified directory or directories, and providing access to the configuration settings.
 *
 * All configuration files are expected to be in the form of nested arrays. At least one configuration file must have
 * an array called 'core' that has the overall settings for the application, and should at a minimum specify the log.
 *
 * If two configurations have overlapping settings, the system will attempt to merge them, with new settings replacing
 * old settings if they exist. For this reason, it is not recommended to parse an entire folder that has conflicting or
 * overlapping configurations, as the results may be unpredictable.
 */
class Configuration
{
    protected $parsed_files = array();
    protected $configuration = array();
    static $iteration = 0;

    public function __construct(?string $config_path = null)
    {
        if (is_dir($config_path)) {
            $this->parseFolder($config_path);
        } elseif (is_file($config_path)) {
            $this->parseFile($config_path);
        }
    }

    /**
     * Process the specified folder for log files, processing each file in turn. This is NOT recursive.
     *
     * @param string $path The path to the folder
     */
    public function parseFolder(string $path): void
    {
        //TODO: Implement me!
    }

    /**
     * Process a single file's configuration settings.
     *
     * @param string $path The path to the configuration file
     *
     * @return bool True if the file is parsed successfully or skipped because it has already been parsed
     */
    public function parseFile(string $path): bool
    {
        static::$iteration++;
        if (static::$iteration > 10) exit();
        if (in_array($path, $this->parsed_files)) {
            // The file has already been parsed, don't parse it again
            return true;
        }
        $this->parsed_files[] = $path;
        if (is_readable($path)) {
            $array = include($path);
        } else {
            if (isset(Core::i()->log)) {
                Core::i()->log->debug('Config path ' . $path . ' could not be read.');
            }
            return false;
        }
        if (!is_array($array)) {
            if (isset(Core::i()->log)) {
                Core::i()->log->debug('Config file ' . $path . ' is not an array.');
            }
            return false;
        }
        $this->parseArray($array);
        return true;
    }

    /**
     * Process an array of configuration settings
     *
     * @param array $array
     */
    public function parseArray(array $array): void
    {
        $this->configuration = array_merge_recursive($this->configuration, $array);
    }

    public function getConfiguration(string $category): array
    {
        $return = [];
        if (isset($this->configuration[$category])) {
            $return = $this->configuration[$category];
        }
        return $return;
    }
}