<?php

namespace Modules\Modules\Http\Controllers\backend;

use Modules\Core\Http\Controllers\AdminBaseController;
use Modules\Modules\Manager\ModuleManager;
use Pingpong\Modules\Module;
use Pingpong\Modules\Repository;

class ModulesController extends AdminBaseController
{
    /**
     * @var ModuleManager
     */
    private $moduleManager;
    /**
     * @var Repository
     */
    private $modules;

    public function __construct(ModuleManager $moduleManager, Repository $modules)
    {
        parent::__construct();

        $this->moduleManager = $moduleManager;
        $this->modules = $modules;
    }

    /**
     * Display a list of all modules.
     *
     * @return View
     */
    public function index()
    {
        $coreModules = $this->moduleManager->getCoreModules();
        $thirdPartyModules = $this->moduleManager->getThirdPartyModules();

        return view('modules::backend.modules.index', compact('coreModules', 'thirdPartyModules'));
    }

    /**
     * Display module info.
     *
     * @param Module $module
     *
     * @return View
     */
    public function show(Module $module)
    {
        $module = $this->moduleManager->get($module);
        $changelog = $this->moduleManager->changelogFor($module);

        return view('modules::backend.modules.show', compact('module', 'changelog'));
    }

    /**
     * Disable the given module.
     *
     * @param Module $module
     *
     * @return mixed
     */
    public function disable(Module $module)
    {
        if ($this->moduleManager->isCoreModule($module)) {
            return redirect()->route('backend::modules.modules.show', [$module->getLowerName()])
                ->with('error', trans('workshop::modules.module cannot be disabled'));
        }

        $module->disable();
    }

    /**
     * Enable the given module.
     *
     * @param Module $module
     *
     * @return mixed
     */
    public function enable(Module $module)
    {
        $module->enable();
    }
}
