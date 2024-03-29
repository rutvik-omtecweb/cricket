<?php

namespace Database\Seeders;

use App\Models\EmailTemplate;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmailTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmailTemplate::create([
            'title' => 'Verify Member',
            'subject' => 'Verify Your Member Registration',
            'content' => '<p><span style="font-size: 1rem;">Dear [name],</span><br></p><p><span style="font-size: 1rem;">Thank you for registering as a member with [company_name]. We are excited to have you on board! To complete the registration process and gain access to your account, please verify your email address by clicking the link below:</span><br></p><p><span style="font-size: 1rem;">[verification_link]</span><br></p><p><span style="font-size: 1rem;">Please note that this link will expire in [X] hours, so be sure to verify your email address promptly.</span></p><p><span style="font-size: 1rem;">We look forward to a successful partnership. Thank you for choosing [Your Company Name]!</span><br></p><p><span style="font-size: 1rem;">Best regards,</span><br></p><p><span style="font-size: 1rem;">[company_name]</span><br></p><p>[company_contact_info]</p><div><br></div>',
        ]);

        EmailTemplate::create([
            'title' => 'Event',
            'subject' => 'Invitation Of Event',
            'content' => '<div>Dear [name],</div><div><br></div><div>We are excited to invite you to our upcoming event, [Event Title], scheduled to take place on [Event Date]. Below are the details:</div><div><br></div><div>Start Date : [Event Start Date]</div><div>End Date : [Event End Date]</div><div>Number Of Team: [Number Of Team]</div><div>Team Price: [Team Price]</div><div>Participant Price: [Participant Price]</div><div><br></div><div>We are looking forward to your participation and making this event a great success.</div><div><br></div><div>If you have any questions or need further information, feel free to contact us at [Contact Information].</div><div><br></div><div>Best regards,</div><div>[Company]</div>',
        ]);

        EmailTemplate::create([
            'title' => 'Rejection of Membership',
            'subject' => ' Rejection of Membership Application',
            'content' => '<p>Dear [User],</p><p><span style="font-size: 1rem;">Thank you for your interest in becoming a member of [Website Name].</span><span style="font-size: 1rem;">We appreciate the time and effort you put into your application.</span></p><p><span style="font-size: 1rem;">Unfortunately, after thorough review, we regret to inform you that we are unable to accept your membership&nbsp;</span><span style="font-size: 1rem;">application at this time. The reason for this decision is <b>[reason].</b></span></p><p><span style="font-size: 1rem;">We understand that this news may be disappointing,</span><span style="font-size: 1rem;">&nbsp;and we want to express our gratitude for your interest in joining our platform.</span></p><p><span style="font-size: 1rem;">Thank you once again for considering. We wish you the best in your future endeavors.</span><br></p><p><span style="font-size: 1rem;">Sincerely,</span><br></p><p>[Company]</p>'
        ]);

        EmailTemplate::create([
            'title' => 'Approve of Membership',
            'subject' => 'Your Membership Request has been Approved!',
            'content' => '<p>Dear [user],</p><p><span style="font-size: 1rem;">We are excited to inform you that your membership request with [website name] has&nbsp;</span><span style="font-size: 1rem;">been approved by our administrative team. Welcome to the community!</span></p><p><span style="font-size: 1rem;">Please log in using the following link to complete your profile and explore&nbsp;</span><span style="font-size: 1rem;">the various features and resources available to our members:</span></p><p><span style="font-size: 1rem;">[Login URL]</span></p><p><span style="font-size: 1rem;">Thank you for choosing to be a part of [organization name].We look forward to your active participation and&nbsp;</span><span style="font-size: 1rem;">contributions to our community!</span></p><p><span style="font-size: 1rem;">Sincerely,</span></p><p><span style="font-size: 1rem;">[Company]</span></p>',
        ]);
    }
}
