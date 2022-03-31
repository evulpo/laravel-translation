@extends('translation::layout')

@section('body')

    @if(count($languages))

        <div class="panel w-1/2">

            <div class="panel-header">

            {{__('Languages')}}

                <div class="flex flex-grow justify-end items-center">

                    <a href="{{ route('languages.create') }}" class="button">
                        {{ __('+ Add') }}
                    </a>

                </div>

            </div>

            <div class="panel-body">

                <table>

                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Locale') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($languages as $language => $name)
                            <tr>
                                <td>
                                    {{ $name }}
                                </td>
                                <td>
                                    <a href="{{ route('languages.translations.index', $language) }}">
                                        {{ $language }}
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

        </div>

    @endif

@endsection