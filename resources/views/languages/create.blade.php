@extends('translation::layout')

@section('body')

    <div class="panel w-1/2">

        <div class="panel-header">

            {{ __('Add a new language') }}

        </div>

        <form action="{{ route('languages.store') }}" method="POST">

            <fieldset>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="panel-body p-4">

                    @include('translation::forms.text', ['field' => 'name', 'label' => __('Name'), ])

                    @include('translation::forms.text', ['field' => 'locale', 'label' => __('Locale'), ])

                </div>

            </fieldset>

            <div class="panel-footer flex flex-row-reverse">

                <button class="button button-blue">
                    {{ __('Save') }}
                </button>

            </div>

        </form>

    </div>

@endsection