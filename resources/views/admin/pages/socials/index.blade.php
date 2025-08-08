@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('social.list_title') }}</h5>
                        </div>
                        <a href="{{ route('socials.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> {{ __('social.add_button') }}
                        </a>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    @include('admin.pages.components.success-error')

                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('table.columns.no') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('social.fields.name') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('social.fields.icon') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('social.fields.url') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('social.fields.status') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('social.fields.order') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('table.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($socials as $key => $social)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $social->platform }}</p>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <i class="{{ $social->icon }} fa-lg"></i>
                                                <div class="ms-2">
                                                    <p class="text-xs font-weight-bold mb-0">{{ $social->icon }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{ $social->url }}" class="text-xs font-weight-bold mb-0 text-truncate"
                                               target="_blank" style="max-width: 200px; display: block;">
                                                {{ $social->url }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $social->status ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                {{ $social->status ? __('social.status.active') : __('social.status.inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $social->order }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('socials.edit', $social->id) }}" class="mx-3" title="{{ __('actions.edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $social->id,
                                                'route' => route('socials.destroy', $social->id),
                                                'title' => __('actions.delete'),
                                                'message' => __('messages.confirm.delete', ['item' => __('social.item_name')])
                                            ])
                                        </td>
                                    </tr>
                                @endforeach

                                @if(count($socials) === 0)
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <p class="text-sm text-secondary mb-0">{{ __('social.no_items') }}</p>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>

                        <x-pagination :paginator="$socials" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
