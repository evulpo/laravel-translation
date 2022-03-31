@extends('translation::layout')

@section('body')

    <div class="panel w-1/2">

        <div class="panel-header">

            {{ __('Add a translation') }}

        </div>

        <form action="{{ route('languages.translations.store', $language) }}" method="POST">

            <fieldset>

                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="panel-body p-4">

                    @include('translation::forms.text', ['field' => 'group', 'label' => __('Group (Optional)'), 'placeholder' => __('e.g. validation')])
                    
                    @include('translation::forms.text', ['field' => 'key', 'label' => __('Key'), 'placeholder' => __('e.g. invalid_key')])

                    @include('translation::forms.text', ['field' => 'value', 'label' => __('Value'), 'placeholder' => __('e.g. Keys must be a single string')])
                    
                    <div class="input-group">

                        <button v-on:click="toggleAdvancedOptions" class="text-blue">{{ __('Toggle advanced options') }}</button>

                    </div>

                    <div v-show="showAdvancedOptions">

                        @include('translation::forms.text', ['field' => 'namespace', 'label' => __('Namespace (Optional)'), 'placeholder' => __('e.g. my_package')])
                    
                    </div>

  
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