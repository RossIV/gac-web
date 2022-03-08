<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UserRequest;
use App\Models\Affiliation;
use App\Models\Team;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class UserCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class UserCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     *
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\User::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/user');
        CRUD::setEntityNameStrings('user', 'users');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('first_name');
        CRUD::column('last_name');
        CRUD::column('alt_name');
        CRUD::column('email');
        CRUD::column('phone');

        // Affiliation Filter
        $this->crud->addFilter(
            [
                'name'  => 'affiliation',
                'type'  => 'dropdown',
                'label' => 'Affiliation',
            ],
            Affiliation::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('where', 'affiliation_id', $value);
            }
        );

        // Team Filter
        $this->crud->addFilter(
            [
                'name'  => 'nativeTeams',
                'type'  => 'dropdown',
                'label' => 'Team',
            ],
            Team::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->query = $this->crud->query->whereHas('nativeTeams', function ($query) use ($value) {
                    $query->where('id', $value);
                });
            }
        );

        // Role Filter
        $this->crud->addFilter(
            [
                'name'  => 'role',
                'type'  => 'dropdown',
                'label' => trans('backpack::permissionmanager.role'),
            ],
            config('permission.models.role')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'roles', function ($query) use ($value) {
                    $query->where('role_id', '=', $value);
                });
            }
        );

        // Extra Permission Filter
        $this->crud->addFilter(
            [
                'name'  => 'permissions',
                'type'  => 'select2',
                'label' => trans('backpack::permissionmanager.extra_permissions'),
            ],
            config('permission.models.permission')::all()->pluck('name', 'id')->toArray(),
            function ($value) { // if the filter is active
                $this->crud->addClause('whereHas', 'permissions', function ($query) use ($value) {
                    $query->where('permission_id', '=', $value);
                });
            }
        );
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(UserRequest::class);

        CRUD::field('first_name');
        CRUD::field('last_name');
        CRUD::field('alt_name');
        CRUD::field('email');
        CRUD::field('phone');
        CRUD::field('affiliation_id');
        CRUD::field('emergency_contact_name');
        CRUD::field('emergency_contact_phone');
        CRUD::field('emergency_contact_relationship');
        $this->crud->addField([
            // two interconnected entities
            'label'             => trans('backpack::permissionmanager.user_role_permission'),
            'field_unique_name' => 'user_role_permission',
            'type'              => 'checklist_dependency',
            'name'              => ['roles', 'permissions'],
            'subfields'         => [
                'primary' => [
                    'label'            => trans('backpack::permissionmanager.roles'),
                    'name'             => 'roles', // the method that defines the relationship in your Model
                    'entity'           => 'roles', // the method that defines the relationship in your Model
                    'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
                    'attribute'        => 'name', // foreign key attribute that is shown to user
                    'model'            => config('permission.models.role'), // foreign key model
                    'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns'   => 3, //can be 1,2,3,4,6
                ],
                'secondary' => [
                    'label'          => ucfirst(trans('backpack::permissionmanager.permission_singular')),
                    'name'           => 'permissions', // the method that defines the relationship in your Model
                    'entity'         => 'permissions', // the method that defines the relationship in your Model
                    'entity_primary' => 'roles', // the method that defines the relationship in your Model
                    'attribute'      => 'name', // foreign key attribute that is shown to user
                    'model'          => config('permission.models.permission'), // foreign key model
                    'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
                    'number_columns' => 3, //can be 1,2,3,4,6
                ],
            ],
        ]);
    }

    /**
     * Define what happens when the Update operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }

    /**
     * Define what happens when the Show operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-show
     * @return void
     */
    protected function setupShowOperation()
    {
        $this->crud->set('show.setFromDb', false);

        CRUD::column('first_name');
        CRUD::column('last_name');
        CRUD::column('alt_name');
        CRUD::column('email');
        CRUD::column('email_verified_at');
        CRUD::column('phone');
        $this->crud->addColumn([
           'type' => 'relationship',
           'name' => 'affiliation',
           'label' => 'Affiliation',
           'attribute' => 'name',
           'model' => Affiliation::class,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('affiliation/'.$related_key.'/show');
                },
            ],
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'teams',
            'label' => 'Teams',
            'attribute' => 'name',
            'model' => Team::class,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('team/'.$related_key.'/show');
                },
            ],
        ]);
        CRUD::column('emergency_contact_name');
        CRUD::column('emergency_contact_phone');
        CRUD::column('emergency_contact_relationship');
        CRUD::column('created_at');
        CRUD::column('updated_at');
        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label'     => trans('backpack::permissionmanager.roles'), // Table column heading
            'type'      => 'select_multiple',
            'name'      => 'roles', // the method that defines the relationship in your Model
            'entity'    => 'roles', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => config('permission.models.role'), // foreign key model
        ]);
        $this->crud->addColumn([ // n-n relationship (with pivot table)
            'label'     => trans('backpack::permissionmanager.extra_permissions'), // Table column heading
            'type'      => 'select_multiple',
            'name'      => 'permissions', // the method that defines the relationship in your Model
            'entity'    => 'permissions', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model'     => config('permission.models.permission'), // foreign key model
        ]);
    }
}
