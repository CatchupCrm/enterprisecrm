<?php

namespace Modules\Admin\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class MaintenanceSetCommand extends Command
{
    protected $name = 'cms:maintenance';
    protected $readableName = 'Sets the cms\'s maintenance setting';
    protected $description = 'Sets the cms\'s maintenance setting';

    public function fire()
    {
        $settingStr = 'cms.core.app.maintenance';
        $configValue = config($settingStr) === 'true' ? true : false;
        $newSetting = null;
        if ($this->argument('setting') !== null) {
            $newSetting = ($this->argument('setting') === 'on' ? true : false);
        }

        switch ($newSetting) {
            case null :
                $this->info('Maintenance Turned: ' . (!$configValue ? 'On' : 'Off'));
                save_config_var($settingStr, (!$configValue ? 'true' : 'false'));
                break;

            case true :
                $this->info('Maintenance Turned: On');
                save_config_var($settingStr, 'true');
                break;

            case false :
                $this->info('Maintenance Turned: Off');
                save_config_var($settingStr, 'false');
                break;
        }
        $this->callSilent('cache:clear');
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('setting', InputArgument::OPTIONAL, 'The maintenance value.', null),
        );
    }
}
