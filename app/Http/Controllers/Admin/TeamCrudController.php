<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\TeamRequest;
use App\Models\EventRegistration;
use App\Models\Payment;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class TeamCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class TeamCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Team::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/team');
        CRUD::setEntityNameStrings('team', 'teams');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        CRUD::column('motto');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'owner',
            'label' => 'Leader',
            'attribute' => 'name',
            'model' => User::class
        ]);
        $this->crud->addColumn([
            'name' => 'accept_additional_members',
            'label' => 'Accept Addtl.',
            'type' => 'boolean',
            'options' => [0 => 'No', 1 => 'Yes']
        ]);
        $this->crud->addColumn([
            'type' => 'relationship_count',
            'name' => 'users',
            'label' => 'Members',
            'suffix' => ' Members',
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('user?nativeTeams='.$entry->getKey());
                },
            ],
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']);
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     *
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(TeamRequest::class);

        CRUD::field('name');
        CRUD::field('motto');
        CRUD::field('accept_additional_members');
        $this->crud->addField([
            'type' => 'relationship',
            'name' => 'owner',
            'label' => 'Leader',
            'attribute' => 'name',
            'model' => User::class
        ]);
        $this->crud->addField([
            'type' => 'relationship',
            'name' => 'users',
            'label' => 'Members',
            'attribute' => 'name',
            'model' => User::class
        ]);
        $this->crud->addField([
            'type' => 'relationship',
            'name' => 'invites',
            'label' => 'Invite Members',
            'attribute' => 'name',
            'model' => User::class
        ]);

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number']));
         */
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
        CRUD::column('name');
        CRUD::column('motto');
        $this->crud->addColumn([
            'name' => 'accept_additional_members',
            'label' => 'Accept Additional Members',
            'type' => 'boolean',
            'options' => [0 => 'No', 1 => 'Yes']
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'owner',
            'label' => 'Leader',
            'attribute' => 'name',
            'model' => User::class,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('user/'.$related_key.'/show');
                },
            ],
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'users',
            'label' => 'Members',
            'attribute' => 'name',
            'model' => User::class,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('user/'.$related_key.'/show');
                },
            ],
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'payments',
            'label' => 'Payments',
            'attribute' => 'name',
            'model' => Payment::class,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('payment/'.$related_key.'/show');
                },
            ],
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'invitedUsers',
            'label' => 'Invited Users',
            'attribute' => 'name',
            'model' => User::class
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'registrations',
            'label' => 'Registrations',
            'attribute' => 'name',
            'model' => EventRegistration::class,
            'wrapper'   => [
                'href' => function ($crud, $column, $entry, $related_key) {
                    return backpack_url('event-registration/'.$related_key.'/show');
                },
            ],
        ]);
    }
}
