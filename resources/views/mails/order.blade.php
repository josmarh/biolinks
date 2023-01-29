<x-mail::message>
{{__('Thanks so much for ordering from us!')}}

@if($productType == 'simple_product' || $productType == 'member_product')
{{__('You purchased')}}
@else
{{__('You requested')}}
@endif

{{ $productName }}

for ${{ $price }}

@if($productType == 'simple_product' || $productType == 'member_product')
{{__('Kindly login to your member area to access your order.')}}
@endif

<!-- Add url button if able -->
<x-mail::button :url="$url" color="primary">
Login
</x-mail::button>
</x-mail::message>