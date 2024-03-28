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
    }
}
