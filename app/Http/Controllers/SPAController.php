<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProjectLink;
use App\Models\BiolinkSetting;
use App\Models\LinkSetting;
use App\Models\BiolinkCustomSetting;
use App\Models\BiolinkSection;
use App\Models\LeadStat;
use App\Models\Visitor;
use App\Models\Project;
use App\Models\MembershipBlog;
use App\Models\CustomerLead;
use App\Models\PaymentIntegration;
use App\Models\EmailProviderIntegration;
use App\Jobs\LeadsGenJob;
use App\Jobs\MailSignupJob;
use App\Services\LeadShareService;
use Illuminate\Support\Facades\Auth;

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
        
        if($projectLink && $projectLink->type === 'biolink') {
            $settings = BiolinkSetting::where('link_id', $projectLink->id)->first();
            $custom = BiolinkCustomSetting::where('link_id', $projectLink->id)->first();
            $section = BiolinkSection::where('bl_biolink_sections.link_id', $projectLink->id)
                ->join('bl_biolink_section_settings as sect','bl_biolink_sections.section_id','=','sect.id')
                ->with('section')
                ->orderBy('sect.section_position','asc')
                ->get();
            $pageBckg = json_decode($settings->background_type_content);
            $jdecoded = [
                'pageBckg' => json_decode($settings->background_type_content),
                'video' => json_decode($settings->video),
                'analytics' => json_decode($settings->analytics),
                'seo' => json_decode($settings->seo),
                'socials' => json_decode($settings->socials),
                'branding' => json_decode($settings->branding),
            ];
            $projectLinkId = $linkId;
            $projectId = $projectLink->project_id;

            $project = Project::where('custom_id', $projectId)->first();
            $blog = MembershipBlog::where('project_id', $project->custom_id)->first();
            $blogSetting = json_decode($blog->main_setting);
            $blogRouteName = $blogSetting->urlPath;

            $isPaymentGatewaySet = PaymentIntegration::where('project_id', $projectId)->first();

            $proj = [
                'pname' => $project->name,
                'routename' => $blogRouteName,
                'stripe' => $isPaymentGatewaySet && $isPaymentGatewaySet->stripe_secret ? true : false,
                'paypal' => $isPaymentGatewaySet && $isPaymentGatewaySet->paypal_client && $isPaymentGatewaySet->paypal_secret ? true : false
            ];
            
            return view('biolinkpage.biolink', compact('settings','custom','section','jdecoded','projectLinkId','projectId','proj'));
        }elseif($projectLink && $projectLink->type === 'link') {
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

        $section = BiolinkSection::where('section_id', $data['sectionId'])->first();

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
        if($sectionField->mailchimpAPIKey && $sectionField->mailchimpList) {
            $mailchimp = [
                'name' => '',
                'email' => $request->email,
                'mailchimpKey' => $sectionField->mailchimpAPIKey,
                'mailchimpList' => $sectionField->mailchimpList
            ];
            $this->shareWithMailchimp($mailchimp);
        }

        // send to other esp if available
        $project = ProjectLink::where('id', $section->link_id)->first();
        $esp = EmailProviderIntegration::where('project_id', $project->project_id)->first();
        $this->shareWithESP($esp, $request->email);   

        // send to webhook
        if($sectionField->webhookURL) {
            $webhook = [
                'webhook' => $sectionField->webhookURL,
                'name' => '',
                'email' => $request->email,
            ];
            $this->shareWithWebhook($webhook);
        }

        // save to db
        LeadStat::create([
            'email' => $request->email,
            'name' => null,
            'phone' => null,
            'link_id' => $section->link_id,
            'section_id' => $section->section_id,
            'ip' => \Request::ip()
        ]);
        $leads = LeadStat::where('link_id', $section->link_id)->count();
        ProjectLink::where('id', $section->link_id)->update([
            'total_leads' => $leads
        ]);

        CustomerLead::create([
            'email' => $request->email,
            'name' => '',
            'status' => 'Email Lead',
            'orders' => 0,
            'lifetime_value' => 0.00,
            'project_id' => $request->projectId
        ]);

        return response([
            'message' => $sectionField->thankYouMsg
        ]);
    }

    public function mailSignupBlog(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'projectId' => 'required|numeric'
        ]);

        CustomerLead::create([
            'email' => $data['email'],
            'name' => '',
            'status' => 'Email Lead',
            'orders' => 0,
            'lifetime_value' => 0.00,
            'project_id' => $data['projectId']
        ]);

        // send to esp
        $esp = EmailProviderIntegration::where('project_id', $projectId)->first();
        $this->shareWithESP($esp, $request->email);  

        return response([
            'message' => 'Email signup successfully'
        ]);
    }

    public function leadgen(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'sectionId' => 'required|numeric'
        ]);

        $section = BiolinkSection::where('section_id', $data['sectionId'])->first();

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
        if($sectionField->mailchimpAPIKey && $sectionField->mailchimpList) {
            $mailchimp = [
                'name' => $request->name,
                'email' => $request->email,
                'mailchimpKey' => $sectionField->mailchimpAPIKey,
                'mailchimpList' => $sectionField->mailchimpList
            ];
            $this->shareWithMailchimp($mailchimp);
        }

        // send to esp
        $project = ProjectLink::where('id', $section->link_id)->first();
        $esp = EmailProviderIntegration::where('project_id', $project->project_id)->first();
        $this->shareWithESP($esp, $request->email, $request->name); 

        // send to webhook
        if($sectionField->webhookURL) {
            $webhook = [
                'webhook' => $sectionField->webhookURL,
                'name' => $request->name,
                'email' => $request->email,
            ];
            $this->shareWithWebhook($webhook);
        }

        // Custom conversion code

        // save to db
        LeadStat::create([
            'email' => $request->email,
            'name' => $request->name,
            'phone' => $request->phone,
            'link_id' => $section->link_id,
            'section_id' => $section->section_id,
            'ip' => \Request::ip()
        ]);

        $leads = LeadStat::where('link_id', $section->link_id)->count();
        ProjectLink::where('id', $section->link_id)->update([
            'total_leads' => $leads
        ]);

        CustomerLead::create([
            'email' => $request->email,
            'name' => $request->name,
            'status' => 'Email Lead',
            'orders' => 0,
            'lifetime_value' => 0.00,
            'project_id' => $request->projectId
        ]);

        return response([
            'message' => $sectionField->thankYouMsg
        ]);
    }

    public function storeVisits(Request $request)
    {
        $data = $request->all();

        Visitor::create([
            'link_id'      => $data['linkId'],
            'section_id'   => 0,
            'ip'           => $data['ip'], 
            'country'      => $data['country'], 
            'country_flag' => $data['countryFlag'], 
            'city'         => $data['city'], 
            'os'           => $data['os']
        ]);

        $uniqueClick = Visitor::where('link_id', $data['linkId'])->distinct()->count('ip');
        $link = ProjectLink::find($data['linkId']);

        Project::where('custom_id', $link->project_id)
            ->update(['total_unique_clicks' => $uniqueClick]);

        $link->update([
            'total_unique_clicks' => $uniqueClick
        ]);

        return response(['message' => true]);
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

    public function loginMember(Request $request, $linkId)
    {  
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        
        if(Auth::guard('subscriber')->attempt(['email' => $credentials['email'], 'password' => $credentials['password']])) {
            return redirect()->intended('/w/'.$linkId);
        }else {
            return back()->withInput($request->only('email', 'remember'))->with('error', 'Login failed');
        }
    }

    public function logoutMember(Request $request, $projectLinkId)
    {
        Auth::guard('subscriber')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('biolink-webpage', $projectLinkId);
    }
}
