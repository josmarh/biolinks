<x-mail::message>
{{__('Hi '. $inviteeName.',')}}

{{$invitedBy}} has invited you to collaborate on project <strong>{{$projectName}}</strong> at {{config('app.name')}}.

<x-mail::button :url="$url" color="primary">
JOIN PROJECT
</x-mail::button>

{{__('Welcome to '. config('app.name').'!')}}
</x-mail::message>