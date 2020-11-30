@component('mail::message')
    # Introduction

    <p>
        Bonjour.
    </p>
    <p>
        Vous avez une action (<strong>{{ $step->titre  }}</strong>) à effectuer pour un bordereau de Remise.
    </p>
    <p>
        @component('mail::button', ['url' => $step_url])
            Accéder à l'Action
        @endcomponent
    </p>

    Cordialement,<br>
    {{ config('app.name') }}
@endcomponent
