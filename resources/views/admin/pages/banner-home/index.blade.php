@extends('admin.layouts.app')

@section('content-auth')
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="d-flex flex-row justify-content-between">
                        <div>
                            <h5 class="mb-0">{{ __('banner.list_title') }}</h5>
                        </div>
                        <a href="{{ route('banner-home.create') }}" class="btn bg-gradient-primary btn-sm mb-0 px-2" type="button">
                            <i class="fa-solid fa-plus"></i> {{ __('banner.add_button') }}
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
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('banner.fields.image') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('banner.fields.status') }}</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('banner.fields.order') }}</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">{{ __('table.columns.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $key => $banner)
                                    <tr>
                                        <td class="ps-4">
                                            <p class="text-xs font-weight-bold mb-0">{{ $key + 1 }}</p>
                                        </td>
                                        <td>
                                            <div style="width: 120px; height: 60px; overflow: hidden;">
                                                <img src="{{ Storage::url($banner->image) }}"
                                                    alt="Banner Image"
                                                    class="img-fluid rounded">
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-sm {{ $banner->status ? 'bg-gradient-success' : 'bg-gradient-secondary' }}">
                                                {{ $banner->status ? __('banner.status.active') : __('banner.status.inactive') }}
                                            </span>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $banner->order }}</p>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('banner-home.edit', $banner->id) }}" class="mx-3" title="{{ __('actions.edit') }}">
                                                <i class="fa-solid fa-pencil"></i>
                                            </a>
                                            @include('admin.pages.components.delete-form', [
                                                'id' => $banner->id,
                                                'route' => route('banner-home.destroy', $banner->id),
                                                'title' => __('actions.delete'),
                                                'message' => __('messages.confirm.delete', ['item' => __('banner.item_name')])
                                            ])
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <x-pagination :paginator="$banners" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
