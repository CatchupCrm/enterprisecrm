<?php

namespace Modules\Auth\Http\Controllers\Backend\User;

use Modules\Auth\Datatables\PermissionManager;
use Modules\Admin\Traits\DataTableTrait;
use Modules\Auth\Models\User;

class PermissionController extends BaseUserController
{
    use DataTableTrait;

    public function manager(User $user)
    {
        $this->getUserDetails($user);
        $this->theme->breadcrumb()->add('Permissions', route('admin.user.permissions', $user->id));

        return $this->renderDataTable(with(new PermissionManager())->boot());
    }

    private function getDataTableHtml($data)
    {
        return $this->setView('admin.user._datatable', $data);
    }
}
