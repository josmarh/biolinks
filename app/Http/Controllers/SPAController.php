<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectLink;
use App\Models\BiolinkSetting;
use App\Models\LinkSetting;
use App\Models\BiolinkCustomSetting;
use App\Models\BioLinkSection;
use App\Jobs\LeadsGenJob;
use App\Jobs\MailSignupJob;
use App\Services\LeadShareService;

class SPAController extends Controller
{
    use LeadShareService;

    public function index()
    {
        return view('app');
    }

    public function biolinkPage($linkId)
    {
        $projectLink = ProjectLink::where('link_id', $linkId)->first();

        if($projectLink->type == 'biolink') {
            $settings = BiolinkSetting::where('link_id', $projectLink->id)->first();
            $custom = BiolinkCustomSetting::where('link_id', $projectLink->id)->first();
            $section = BioLinkSection::where('bl_biolink_sections.link_id', $projectLink->id)
                ->join('bl_biolink_section_settings as sect','bl_biolink_sections.section_id','=','sect.id')
                ->with('section')
                ->orderBy('sect.section_position','asc')
                ->get();
            $pageBckg = json_decode($settings->background_type_content);
            $jdecoded = [
                'pageBckg' => json_decode($settings->background_type_content),
                'video' => json_decode($settings->video)
            ];
            
            return view('biolinkpage.biolink', compact('settings','custom','section','jdecoded'));
        }else {
            $linkSetting = LinkSetting::where('link_id', $projectLink->id)->first();

            if($projectLink->status == 'inactive') {
                return redirect('/');
            }else {
                return view('biolinkpage.link', compact('projectLink','linkSetting'));
            }
        }
    }

    public function mailSignup(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'sectionId' => 'required|numeric'
        ]);

        $section = BioLinkSection::where('section_id', $data['sectionId'])->first();

        if(!$section) {
            return response([
                'error' => 'Email could not be signed up!'
            ],422);
        }

        $sectionField = json_decode($section->core_section_fields);

        // send to notification email
        if(isset($sectionField->emailPlaceholder)) {
            $leadInfo = [
                'notifierEmail' => $sectionField->emailPlaceholder,
                'formName' => $sectionField->name,
                'email' => $request->email,
            ];
            dispatch(new MailSignupJob($leadInfo))->delay(3);
        }

        // send to mailchimp
        if(isset($sectionField->mailchimpAPIKey) && isset($sectionField->mailchimpList)) {
            $mailchimp = [
                'name' => '',
                'email' => $request->email,
                'mailchimpKey' => $sectionField->mailchimpAPIKey,
                'mailchimpList' => $sectionField->mailchimpList
            ];
            $this->shareWithMailchimp($mailchimp);
        }

        // send to webhook
        if(isset($sectionField->webhookURL)) {
            $webhook = [
                'webhook' => $sectionField->webhookURL,
                'name' => $request->name,
                'email' => $request->email,
            ];
            $this->shareWithWebhook($webhook);
        }

        return response([
            'message' => $sectionField->thankYouMsg
        ]);
    }

    public function leadgen(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'sectionId' => 'required|numeric'
        ]);

        $section = BioLinkSection::where('section_id', $data['sectionId'])->first();

        if(!$section) {
            return response([
                'error' => 'Email could not be signed up!'
            ],422);
        }

        $sectionField = json_decode($section->core_section_fields);

        if($sectionField->requirePhone == 'yes') {
            $request->validate([
                'phone' => 'required',
            ]);
        }

        // send to notification email
        if(isset($sectionField->leadNotifyEmail)) {
            $leadInfo = [
                'notifierEmail' => $sectionField->leadNotifyEmail,
                'formName' => $sectionField->formName,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
            ];
            dispatch(new LeadsGenJob($leadInfo))->delay(3);
        }

        // send to mailchimp
        if(isset($sectionField->mailchimpAPIKey) && isset($sectionField->mailchimpList)) {
            $mailchimp = [
                'name' => $request->name,
                'email' => $request->email,
                'mailchimpKey' => $sectionField->mailchimpAPIKey,
                'mailchimpList' => $sectionField->mailchimpList
            ];
            $this->shareWithMailchimp($mailchimp);
        }

        // send to webhook
        if(isset($sectionField->webhookURL)) {
            $webhook = [
                'webhook' => $sectionField->webhookURL,
                'name' => $request->name,
                'email' => $request->email,
            ];
            $this->shareWithWebhook($webhook);
        }

        // save to db

        return response([
            'message' => $sectionField->thankYouMsg
        ]);
    }

    public function linkPasswordValidate(Request $request, $id)
    {
        $data = $request->validate([
            'password' => 'required|string'
        ]); 
        $linkSetting = LinkSetting::findOrFail($id);
        $projectLink = ProjectLink::where('link_id', $linkSetting->link_id)->first();

        if($linkSetting->protection_password == $data['password']) {
            if($projectLink->long_url) {
                return redirect()->away($projectLink->long_url);
            }else {
                return redirect('/');
            }
        }else {
            return redirect()->route('biolink-webpage', $linkSetting->link_id)->with('status', 'Wrong password!');
        }
    }
}
