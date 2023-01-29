<?php

namespace App\Observers;

use App\Models\Project;
use App\Models\PaymentIntegration;
use App\Models\EmailProviderIntegration;
use App\Models\MembershipBlog;

class ProjectObserver
{
    /**
     * Handle the Project "created" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function created(Project $project)
    {
        PaymentIntegration::create([
            'project_id' => $project->custom_id,
            'stripe_status' => 'disabled',
            'stripe_secret' => null,
            'paypal_status' => 'disabled',
            'paypal_secret' => null,
            'paypal_client' => null
        ]);

        EmailProviderIntegration::create([
            'project_id' => $project->custom_id,
            'mailchimp' => json_encode((object)["apikey" => "","listid" => ""]),
            'getresponse' => json_encode((object)["apikey" => "","campaignId" => ""]),
            'emailoctopus' => json_encode((object)["apikey" => "","listid" => ""]),
            'converterkit' => json_encode((object)["apikey" => "","formId" => ""]),
            'mailerlite' => json_encode((object)["apikey" => "","groupId" => ""])
        ]);

        MembershipBlog::create([
            'project_id' => $project->custom_id,
            'headline_color' => '#000000',
            'text_color' => '#888888',
            'bg_color' => '#FFFFFF',
            'button_color' => '#07bbf1',
            'link_color' => '#001828',
            'post_bg_color' => '#FFFFFF',
            'title' => 'My blog / membership',
            'sub_heading' => 'My blog / membership',
            'disclaimer' => null,
            'header_font_family' => 'BlinkMacSystemFont',
            'text_font_family' => 'Avenir',
            'posts' => 'single post',
            'subsscriber_alert' => 'show',
            'subsscriber_alert_color' => '#FFFFFF',
            'emailbox' => 'hide',
            'post_gated_content' => 'Want to unlock more content from us? Subscribe and get exclusive content.',
            'main_setting'  => json_encode((object)[
                'urlPath'   => 'members',
                'imgUrl'    => '',
                'imgUpload' => null,
                'showSubLoginBar'       => 'yes',
                'showTotalSubscribers'  => 'yes',
                'memberNickName'        => '',
                'memberNickNamePlural'  => '',
            ]),
            'smedia' => json_encode((object)[
                'facebook'  => '',
                'twitter'   => '',
                'instgram'  => '',
                'pinterest' => '',
                'youtube'   => '',
                'linkedin'  => '',
                'tiktok'    => ''
            ]),
        ]);
    }

    /**
     * Handle the Project "updated" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function updated(Project $project)
    {
        //
    }

    /**
     * Handle the Project "deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function deleted(Project $project)
    {
        //
    }

    /**
     * Handle the Project "restored" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function restored(Project $project)
    {
        //
    }

    /**
     * Handle the Project "force deleted" event.
     *
     * @param  \App\Models\Project  $project
     * @return void
     */
    public function forceDeleted(Project $project)
    {
        //
    }
}
