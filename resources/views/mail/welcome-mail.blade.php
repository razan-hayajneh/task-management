@component('mail::message')
    # Welcome To Task Management

    The body of your message.

    @component('mail::button', ['url' => 'http://task-management.test/'])
        Go to website
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
