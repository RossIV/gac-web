<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\PaymentRequest;
use App\Models\EventRegistration;
use App\Models\PaymentMethod;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('payment', 'payments');
    }

    /**
     * Define what happens when the List operation is loaded.
     *
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $this->crud->addColumn([
            'type' => 'number',
            'name' => 'amount',
            'label' => 'Amount Paid',
            'prefix' => '$',
            'decimals' => 2
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'method',
            'label' => 'Payment Method',
            'attribute' => 'name',
            'model' => PaymentMethod::class
        ]);
        CRUD::column('notes');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'payable',
            'label' => 'Payable',
            'attribute' => 'name',
            'model' => EventRegistration::class
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
        CRUD::setValidation(PaymentRequest::class);

        CRUD::field('amount');
        CRUD::field('notes');
        $this->crud->addField([
            'type' => 'relationship',
            'name' => 'payable',
            'label' => 'Payable',
            'attribute' => 'name',
            'model' => EventRegistration::class
        ]);
        $this->crud->addField([
            'type' => 'relationship',
            'name' => 'method',
            'label' => 'Payment Method',
            'attribute' => 'name',
            'model' => PaymentMethod::class
        ]);
        CRUD::field('requested_at');
        CRUD::field('paid_at');

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
        CRUD::setValidation(PaymentRequest::class);

        CRUD::field('amount');
        CRUD::field('notes');
        $this->crud->addField([
            'type' => 'relationship',
            'name' => 'method',
            'label' => 'Payment Method',
            'attribute' => 'name',
            'model' => PaymentMethod::class
        ]);
        CRUD::field('requested_at');
        CRUD::field('paid_at');
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
        $this->crud->addColumn([
            'type' => 'number',
            'name' => 'amount',
            'label' => 'Amount Paid',
            'prefix' => '$',
            'decimals' => 2
        ]);
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'method',
            'label' => 'Payment Method',
            'attribute' => 'name',
            'model' => PaymentMethod::class
        ]);
        CRUD::column('notes');
        $this->crud->addColumn([
            'type' => 'relationship',
            'name' => 'payable',
            'label' => 'Payable',
            'attribute' => 'name',
            'model' => EventRegistration::class
        ]);
        CRUD::column('requested_at');
        CRUD::column('paid_at');
    }
}
