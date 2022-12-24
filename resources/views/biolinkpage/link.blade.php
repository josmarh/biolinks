@extends('biolinkpage.linklayout')
    <!-- @if(isset($linkSetting->protection_password))
    <form action="{{ route('link-password.validate', $linkSetting->id) }}" method="post">

    </form>
    @endif -->
@section('content')

<script>
$(document).ready(function(){
    function getClientInfo() {
        $.ajax({
            url: 'https://api.ipgeolocation.io/ipgeo?apiKey=71ec1774e54b4b0f979cefe8d8f0e4bb',
            method: 'get',
            success: function(res) {
                getOS(res)
            },
            error: function(err) {
                if(err.response){
                    if (err.response.data.hasOwnProperty('message')) {
                        console.log('ipgeo: ' + err.response.data.message)
                    }else {
                        console.log('ipgeo: ' + err.response.data.error)
                    }
                } 
            }
        });
    }

    function getOS(ipInfo) {
        let userAgent = window.navigator.userAgent,
        platform = window.navigator.platform,
        macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
        windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
        iosPlatforms = ['iPhone', 'iPad', 'iPod'],
        os = 'Unknown OS';

        if (macosPlatforms.indexOf(platform) !== -1) {
            os = 'Mac OS';
        } else if (iosPlatforms.indexOf(platform) !== -1) {
            os = 'iOS';
        } else if (windowsPlatforms.indexOf(platform) !== -1) {
            os = 'Windows';
        } else if (/Android/.test(userAgent)) {
            os = 'Android';
        } else if (!os && /Linux/.test(platform)) {
            os = 'Linux';
        }
        postVisitorInfo(ipInfo, os)
    }

    function postVisitorInfo(ipInfo, os) {
        $.ajax({
            url: '/api/visits',
            method: 'post',
            data: {
                linkId: {!! $linkSetting->link_id !!},
                ip: ipInfo.ip,
                country: ipInfo.country_name,
                countryFlag: ipInfo.country_flag,
                city: ipInfo.city,
                os: os
            },
            success: (res) => {},
            error: (err) => {
                if(err.response){
                    if (err.response.data.hasOwnProperty('message')) {
                        console.log('postVisitorInfo: ' + err.response.data.message)
                    }else {
                        console.log('postVisitorInfo: ' + err.response.data.error)
                    }
                } 
            }
        });
    }

    getClientInfo();
});
</script>
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
    redirectUser();
}

if(hasPassword) {

}

if(isSensitiveContent == 'yes') {

}

function redirectUser() {
    if(longUrl) {
        setTimeout(() => {
            window.location = longUrl;
        }, 1500);
    }else {
        window.location = siteUrl;
    }
}

function redirectToExpiredLink() {
    if(redirect) {
        setTimeout(() => {
            window.location = redirect;
        }, 1500);
    }else {
        window.location = siteUrl;
    }
}
</script>

@endsection