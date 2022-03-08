@extends(backpack_view('blank'))

@php
    $eventRegistrationsCount = \App\Models\EventRegistration::count();
    $widgets['before_content'][] = [
        'type'        => 'progress',
        'class'       => 'card text-white bg-primary mb-2',
        'value'       => $eventRegistrationsCount,
        'description' => 'Event Registrations',
        'progress'    => $eventRegistrationsCount / 20 * 100,
        'hint'        => '',
    ];

    $unpaidPaymentsCount = \App\Models\Payment::unpaid()->count();
    $widgets['before_content'][] = [
        'type'        => 'progress',
        'class'       => 'card text-white bg-success mb-2',
        'value'       => $unpaidPaymentsCount,
        'description' => 'Unpaid Payments',
        'progress'    => 0,
        'hint'        => '',
    ];

    $paidPayments = \App\Models\Payment::paid()->sum('amount');
    $widgets['before_content'][] = [
        'type'        => 'progress',
        'class'       => 'card text-white bg-warning mb-2',
        'value'       => '$' . $paidPayments,
        'description' => 'Payments Received',
        'progress'    => 0,
        'hint'        => '',
    ];
@endphp

@section('content')
@endsection
