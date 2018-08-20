Hola {{ $user->name }}
Gracias por crear una nueva cuenta. Por favor verificala en el siguiente enlace.

{{ route('verify',$user->verification_token) }}
