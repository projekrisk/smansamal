@php
    $maintenanceData = \App\Http\Middleware\CheckMaintenanceMode::getMaintenanceData();
@endphp
@include('maintenance', $maintenanceData)
