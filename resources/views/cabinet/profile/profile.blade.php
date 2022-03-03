@php /** @var User $user */use App\Models\User;@endphp
<button onclick="location.href='{{ route('cabinet.profile.edit') }}'"
        class="btn btn-outline btn-go-on btn-edit-profile">{{ __('Edit') }}</button>
<table class="table">
    <thead>
    <th>{{ __('LastName') }}</th>
    <th>{{ __('Name') }}</th>
    <th>{{ __('MiddleName') }}</th>
    <th>{{ __('Email') }}</th>
    <th>{{ __('Phone') }}</th>
    <th>{{ __('DeliveryUserAddress') }}</th>
    </thead>
    <tbody>
    <tr>
        <td>{{ $user->last_name }}</td>
        <td>{{ $user->name }}</td>
        <td>{{ $user->middle_name }}</td>
        <td>{{ $user->email }}</td>
        <td>{{ $user->phone }}</td>
        <td>
            @if($user->delivery_place)
                <ul>
                    @if($user->delivery_place->city)
                        <li><b>{{ __('City') }}:</b> {{ $user->delivery_place->city }}</li>@endif
                    @if($user->delivery_place->street)
                        <li><b>{{ __('Street') }}:</b> {{ $user->delivery_place->street }}</li>@endif
                    @if($user->delivery_place->house_number)
                        <li><b>{{ __('HouseNumber') }}:</b> {{ $user->delivery_place->house_number }}</li>@endif
                    @if($user->delivery_place->apartment)
                        <li><b>{{ __('Apartment') }}:</b> {{ $user->delivery_place->apartment }}</li>@endif
                </ul>
            @endif
        </td>
    </tr>
    </tbody>
</table>

