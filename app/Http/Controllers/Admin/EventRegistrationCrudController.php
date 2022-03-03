<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\EventRegistrationRequest;
use App\Models\Payment;
use App\Models\User;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class EventRegistrationCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class EventRegistrationCrudController extends CrudController
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
        CRUD::setModel(\App\Models\EventRegistration::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/event-registration');
        CRUD::setEntityNameStrings('event registration', 'event registrations');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('event_id');
        CRUD::column('team_id');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'user',
            'label' => 'Team Leader',
            'attribute' => 'name',
            'model' => User::class
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
        CRUD::setValidation(EventRegistrationRequest::class);

        CRUD::field('event_id');
        CRUD::field('team_id');
        CRUD::field('user_id');
        CRUD::field('external_notes');
        CRUD::field('internal_notes');
        CRUD::field('payments');

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
        $this->crud->set('show.setFromDb', false);

        CRUD::column('event_id');
        CRUD::column('team_id');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'user',
            'label' => 'Team Leader',
            'attribute' => 'name',
            'model' => User::class
        ]);
        CRUD::column('terms_agreed_at');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'termsAgreedByUser',
            'label' => 'Terms Agreed By',
            'attribute' => 'name',
            'model' => User::class
        ]);
        CRUD::column('external_notes');
        CRUD::column('internal_notes');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'payments',
            'label' => 'Payments',
            'attribute' => 'name',
            'model' => Payment::class
        ]);
        CRUD::column('created_at');
        CRUD::column('updated_at');
        CRUD::column('deleted_at');
    }
}
