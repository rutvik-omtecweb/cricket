<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Menu::create([
            'menu_name' => 'Dashboard',
            'icon' => 'fa-tachometer-alt',
            'page_url' => 'admin.dashboard',
            'order' => 1,
        ]);

        $home = Menu::create([
            'menu_name' => 'Content Management',
            'icon' => 'fa-edit',
            'page_url' => '#',
            'order' => 2,
        ]);

        Menu::create([
            'menu_name' => 'Banner',
            'icon' => 'fa-images',
            'page_url' => 'admin.banners.index',
            'parent_id' => $home->id,
            'order' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Home Page Content',
            'icon' => 'fas fa-highlighter',
            'page_url' => 'admin.home-content.index',
            'parent_id' => $home->id,
            'order' => 2,
        ]);

        Menu::create([
            'menu_name' => 'News',
            'icon' => 'fa fa-newspaper',
            'page_url' => 'admin.news.index',
            'parent_id' => $home->id,
            'order' => 3,
        ]);

        Menu::create([
            'menu_name' => 'About US',
            'icon' => 'fa fa-info',
            'page_url' => 'admin.about.us.store',
            'parent_id' => $home->id,
            'order' => 4,
        ]);

        Menu::create([
            'menu_name' => 'Live Score',
            'icon' => 'fas fa-stream',
            'page_url' => 'admin.live-score.index',
            'parent_id' => $home->id,
            'order' => 5,
        ]);

        $event = Menu::create([
            'menu_name' => 'Events & Tournaments',
            'icon' => 'fas fa-calendar-alt',
            'page_url' => '#',
            'order' => 3,
        ]);

        Menu::create([
            'menu_name' => 'Events',
            'icon' => 'fas fa-calendar-alt',
            'page_url' => 'admin.events.index',
            'parent_id' => $event->id,
            'order' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Past Tournaments',
            'icon' => 'fa fa-trophy',
            'page_url' => 'admin.tournaments.index',
            'parent_id' => $event->id,
            'order' => 2,
        ]);

        Menu::create([
            'menu_name' => 'Photos',
            'icon' => 'fa fa-image',
            'page_url' => 'admin.photos.index',
            'parent_id' => $event->id,
            'order' => 3,
        ]);

        $member = Menu::create([
            'menu_name' => 'Members & Teams',
            'icon' => 'fas fa-user',
            'page_url' => '#',
            'order' => 4,
        ]);

        Menu::create([
            'menu_name' => 'New Join Members',
            'icon' => 'fas fa-user-check',
            'page_url' => 'admin.new-join-member.index',
            'parent_id' => $member->id,
            'order' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Members',
            'icon' => 'fas fa-user',
            'page_url' => 'admin.members.index',
            'parent_id' => $member->id,
            'order' => 2,
        ]);

        Menu::create([
            'menu_name' => 'Teams',
            'icon' => 'fas fa-users',
            'page_url' => 'admin.teams.index',
            'parent_id' => $member->id,
            'order' => 2,
        ]);

        $system = Menu::create([
            'menu_name' => 'System Management',
            'icon' => 'fa fa-bars',
            'page_url' => '#',
            'order' => 5,
        ]);

        Menu::create([
            'menu_name' => 'Sponsors',
            'icon' => 'far fa-handshake',
            'page_url' => 'admin.sponsors.index',
            'parent_id' => $system->id,
            'order' => 1,
        ]);

        Menu::create([
            'menu_name' => 'CMS Page',
            'icon' => 'fa-edit',
            'page_url' => 'admin.cms.index',
            'parent_id' => $system->id,
            'order' => 2,
        ]);


        Menu::create([
            'menu_name' => 'Contact Us',
            'icon' => 'fa-envelope-open-text',
            'page_url' => 'admin.contact.us',
            'parent_id' => $system->id,
            'order' => 3,
        ]);

        $setting = Menu::create([
            'menu_name' => 'Settings',
            'icon' => 'fa fa-cogs',
            'page_url' => '#',
            'order' => 6,
        ]);

        Menu::create([
            'menu_name' => 'General Setting',
            'icon' => 'fa-tools',
            'page_url' => 'admin.general.setting',
            'parent_id' => $setting->id,
            'order' => 1,
        ]);

        Menu::create([
            'menu_name' => 'Payment Config',
            'icon' => 'fa fa-credit-card',
            'page_url' => 'admin.payment.index',
            'parent_id' => $setting->id,
            'order' => 2,
        ]);

        Menu::create([
            'menu_name' => 'Email Template',
            'icon' => 'fa-tachometer-alt',
            'page_url' => 'admin.email-template.index',
            'parent_id' => $setting->id,
            'order' => 3,
        ]);

        Menu::create([
            'menu_name' => 'Admin User',
            'icon' => 'fa-user-cog',
            'page_url' => 'admin.admin-user.index',
            'parent_id' => $setting->id,
            'order' => 3,
        ]);
    }
}
