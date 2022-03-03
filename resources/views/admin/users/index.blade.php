@extends('layouts.app')
@section('description', __(''))
@section('title', __('Users'))
@section('content')
    <section id="admin">
        <div class="container">
            <div class="admin-users">
                @include('admin.users._nav')
                <h1>{{ __('Users') }}</h1>
                <button onclick="window.location.href='{{ route('admin.users.create') }}'"
                        class="btn btn-outline">{{ __('Create') }}</button>
                <form action="?" method="GET">
                    <div class="filter">
                        <div class="form-input">
                            <label for="id" class="form-input-label">{{ __('ID') }}</label>
                            <input id="id" class="input" name="id" value="{{ request('id') }}">
                        </div>
                        <div class="form-input">
                            <label for="name" class="form-input-label">{{ __('Name') }}</label>
                            <input id="name" class="input" name="name" value="{{ request('name') }}">
                        </div>
                        <div class="form-input">
                            <label for="email" class="form-input-label">{{ __('Email') }}</label>
                            <input id="email" class="input" name="email" value="{{ request('email') }}">
                        </div>
                        <div class="form-input">
                            <label for="phone" class="form-input-label">{{ __('Phone') }}</label>
                            <input type="tel" name="phone" id="phone" class="input mask-input"
                                   value="{{ request('phone') }}">
                        </div>
                        <div class="form-input">
                            <label for="role" class="form-input-label">{{ __('Role') }}</label>
                            <select id="role" class="input" name="role">
                                @foreach ($roles as $role => $label)
                                    <option value="{{ $role }}" @if ($role === request('role')) selected @endif>{{
                                        $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-input">
                        <button type="submit" class="btn btn-outline btn-go-on ml">{{ __('Search') }}</button>
                    </div>
                </form>
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('ID') }}</th>
                        <th>{{ __('Name') }}</th>
                        <th>{{ __('Email') }}</th>
                        <th>{{ __('Phone') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Role') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @php /** @var User $user */use App\Models\User; @endphp
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td><a class="link edit" href="{{ route('admin.users.show', $user) }}">{{ $user->name }}</a></td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>
                                @if ($user->isWait())
                                    <span class="badge-waiting">{{ __('Waiting') }}</span>
                                @endif
                                @if ($user->isActive())
                                    <span class="badge-active">{{ __('Active') }}</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge-admin">{{ __('Admin') }}</span>
                                @else
                                    <span class="badge-user">{{ __('User') }}</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if($users->total() > $users->count())
                    <div class="paginator-wrap">{{ $users->links() }}</div>
                @endif
            </div>
        </div>
    </section>
@endsection
