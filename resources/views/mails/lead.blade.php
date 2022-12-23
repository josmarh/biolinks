<x-mail::message>
{{__('Here are details of the lead')}}

Form Name: {{$formName}}

@if(isset($name))
Name: {{$name}}
@endif

Email: {{$email}}

@if(isset($phone))
Phone: {{$phone}}
@endif
</x-mail::message>