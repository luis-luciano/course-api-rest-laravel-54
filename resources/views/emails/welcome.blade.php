@component('mail::message')
# Hola {{ $user->name }}
Gracias por crear una nueva cuenta. Por favor verificala en el siguiente enlace.

@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirmar cuenta
@endcomponent

Gracias.<br>
{{ config('app.name') }} 
@endcomponent
