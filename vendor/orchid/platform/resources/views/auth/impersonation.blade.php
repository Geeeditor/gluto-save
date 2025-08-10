@extends('platform::auth')
@section('title',__('Access Denied: Viewing as Another User'))

@section('content')
    <h1 style="margin: auto; text-align: center" class="mb-4 text-body-emphasis h4">{{__('Account Switched')}}</h1>

    <a  class="btn-block btn btn-default" href="{{route('dashboard')}}">
        Go to user Dashboard
</a>

    <form role="form"
          method="POST"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="false"
          data-action="form#submit"
          action="{{ route('platform.switch.logout') }}">
        @csrf

        <p>
            {{ __("You are currently viewing this page on behalf of the current impersonated user. you can now perform actions on the user dashboard on behalf of this user.") }}
        </p>

        <button id="button-login" type="submit" class="btn-block btn btn-default" tabindex="2">
            <x-orchid-icon path="bs.box-arrow-in-right" class="me-2 small"/> {{__('Switch to My Account')}}
        </button>



    </form>


@endsection
