@component('mail::message')
# Hola {{ $user->name }}
Has cambiado tu correo electronico. Por favor verificalo usando el siguiente enlace

@component('mail::button', ['url' => route('verify',$user->verification_token)])
Confirmar cuenta
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
