<?php namespace Modules\Modules\Manager;

use Illuminate\Config\Repository as Config;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Pingpong\Modules\Module;
use Symfony\Component\Yaml\Parser;

class ModuleManager
{
    /**
     * @var Module
     */
    private $module;
    /**
     * @var Config
     */
    private $config;
    /**
     * @var PackageInformation
     */
    private $packageVersion;
    /**
     * @var Filesystem
     */
    private $finder;

    /**
     * @param Config $config
     * @param PackageInformation $packageVersion
     * @param Filesystem $finder
     */
    public function __construct(Config $config, PackageInformation $packageVersion, Filesystem $finder)
    {
        $this->module = app('modules');
        $this->config = $config;
        $this->packageVersion = $packageVersion;
        $this->finder = $finder;
    }


    /**
     * Return a modules
     * @return \Illuminate\Support\Collection
     */
    public function get(Module $module)
    {
        $moduleName = $module->getName();
        $package = $this->packageVersion->getPackageInfo("society/$moduleName-module");
        $module->version = isset($package->version) ? $package->version : 'N/A';
        $module->versionUrl = '#';

        $module->isCore = $this->isCoreModule($module);

        if (isset($package->source->url)) {
            $packageUrl = str_replace('.git', '', $package->source->url);
            $module->versionUrl = $packageUrl . '/tree/' . $package->dist->reference;
        }

        return $module;
    }


    /**
     * Return all modules
     * @return \Illuminate\Support\Collection
     */
    public function all()
    {
        $modules = new Collection($this->module->all());

        foreach ($modules as $module) {
            $module = $this->get($module);
        }

        return $modules;
    }

    /**
     * Return all the enabled modules
     * @return array
     */
    public function enabled()
    {
        return $this->module->enabled();
    }

    /**
     * Get the core modules as an array of names
     * @return array|mixed
     */
    public function getCoreModulesByName()
    {
        $coreModules = $this->config->get('society.core.core.CoreModules');
        $coreModules = array_flip($coreModules);

        return collect($coreModules);
    }

    /**
     * Get the core modules that shouldn't be disabled
     * @return array|mixed
     */
    public function getCoreModules()
    {
        $coreModulesByName = $this->getCoreModulesByName();

        $coreModules = $this->all()->filter(
            function ($module) use ($coreModulesByName) {
                return array_key_exists($module->getLowerName(), $coreModulesByName->toArray());
            });

        return $coreModules->all();
    }

    /**
     * Check if the given module is a core module that should be be disabled
     * @param Module $module
     * @return bool
     */
    public function isCoreModule(Module $module)
    {
        $coreModulesByName = $this->getCoreModulesByName();
        return $coreModulesByName->has($module->getLowerName());
    }

    /**
     * Get the core modules that shouldn't be disabled
     * @return array|mixed
     */
    public function getThirdPartyModules()
    {
        $coreModulesByName = $this->getCoreModulesByName();

        $thirdPartyModules = $this->all()->reject(
            function ($module) use ($coreModulesByName) {
                return array_key_exists($module->getLowerName(), $coreModulesByName->toArray());
            });

        return $thirdPartyModules->all();
    }

    /**
     * Get the enabled modules, with the module name as the key
     * @return array
     */
    public function getFlippedEnabledModules()
    {
        $enabledModules = $this->module->enabled();

        $enabledModules = array_map(function (Module $module) {
            return $module->getName();
        }, $enabledModules);

        return array_flip($enabledModules);
    }

    /**
     * Disable the given modules
     * @param $enabledModules
     */
    public function disableModules($enabledModules)
    {
        $coreModules = $this->getCoreModules();

        foreach ($enabledModules as $moduleToDisable => $value) {
            if (isset($coreModules[$moduleToDisable])) {
                continue;
            }
            $module = $this->module->get($moduleToDisable);
            $module->disable();
        }
    }

    /**
     * Enable the given modules
     * @param $modules
     */
    public function enableModules($modules)
    {
        foreach ($modules as $moduleToEnable => $value) {
            $module = $this->module->get($moduleToEnable);
            $module->enable();
        }
    }

    /**
     * Get the changelog for the given module
     * @param Module $module
     * @return array
     */
    public function changelogFor(Module $module)
    {
        $path = $module->getPath() . '/changelog.yml';
        if (!$this->finder->isFile($path)) {
            return [];
        }

        $yamlParser = new Parser();

        $changelog = $yamlParser->parse(file_get_contents($path));

        $changelog['versions'] = $this->limitLastVersionsAmount(array_get($changelog, 'versions', []));

        return $changelog;
    }

    /**
     * Limit the versions to the last 5
     * @param array $versions
     * @return array
     */
    private function limitLastVersionsAmount(array $versions)
    {
        return array_slice($versions, 0, 5);
    }
}
