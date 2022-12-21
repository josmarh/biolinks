@extends('biolinkpage.linklayout')
    <!-- @if(isset($linkSetting->protection_password))
    <form action="{{ route('link-password.validate', $linkSetting->id) }}" method="post">

    </form>
    @endif -->
@section('content')

<script>
let longUrl = '<?php echo $projectLink->long_url ?>';
let schedule = '<?php echo $linkSetting->tempurl_schedule ?>';
let redirect = '<?php echo $linkSetting->tempurl_expire_url ?>';
let hasPassword = '<?php echo $linkSetting->protection_password ?>';
let isSensitiveContent = '<?php echo $linkSetting->protection_consent_warning ?>';
let siteUrl = window.location.protocol+'//'+window.location.host;
const currentDate = new Date().getTime();

if(schedule == 'yes') {
    let startDate = new Date('<?php echo $linkSetting->tempurl_start_date ?>').getTime();
    let endDate = new Date('<?php echo $linkSetting->tempurl_end_date ?>').getTime();
    let setClickLimit = '<?php echo $linkSetting->tempurl_click_limit ?>';
    let visitorClickCount = 5;

    if(currentDate >= startDate && currentDate <= endDate) {
        if(visitorClickCount >= setClickLimit) {
            redirectToExpiredLink();
        }else {
            redirectUser();
        }
    }else if(currentDate > endDate) {
        redirectToExpiredLink();
    }else {
        window.location = siteUrl;
    }
}else {
    window.location = siteUrl;
}

if(hasPassword) {

}

if(isSensitiveContent == 'yes') {

}

function redirectUser() {
    if(longUrl) {
        window.location = longUrl;
    }else {
        window.location = siteUrl;
    }
}

function redirectToExpiredLink() {
    if(redirect) {
        window.location = redirect;
    }else {
        window.location = siteUrl;
    }
}
</script>

@endsection