<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use App\Models\News;
use App\Models\Banner;
use App\Models\HomepageContent;
use App\Models\Sponsors;
use App\Models\Tournament;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Banner::create([
            'title' => "WELCOME ! Northren Alberta Cricket Association",
            'order' => '1',
            'image' => "carousel-1.jpg",
            'is_active' => true
        ]);

        Banner::create([
            'title' => "Cricket Fever Special",
            'order' => '2',
            'image' => "carousel-2.jpg",
            'is_active' => true
        ]);

        Banner::create([
            'title' => "Best Cricket Matches",
            'order' => '3',
            'image' => "carousel-3.jpg",
            'is_active' => true
        ]);

        HomepageContent::create([
            'description' => "<p><span style='font-family: Amiko, sans-serif; font-size: 18px;'>Northern Alberta Cricket Association (NACA) was formed in 2014/15 in order to: encourage and foster the playing of cricket, Senior, Women and junior, in the province of Alberta; bring all the cricket clubs in Fort MacMurray in touch with one another; and, affiliated with the Alberta Cricket Association (ACA) &amp; Cricket Canada. Every cricket club in Fort McMurray is eligible for membership. The Bylaws of the Association, which outlines all of these regulations. NACA is controlled and managed by a governing Board, and is to be governed by the rules of the ICC &amp; Marylebone Cricket Club.</span><br></p>",
            'image' => 'home_content.jpg',
            'is_active' => true
        ]);

        News::create([
            'news_name' => 'Lorem ipsum dolor sit amet, consectetur adipisicing',
            'description' => 'Lorem ipsum dolor',
            'image' => 'img-news-1.jpg',
            'is_active' => true
        ]);

        News::create([
            'news_name' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'description' => 'Lorem ipsum dolor',
            'image' => 'img-news-2.jpg',
            'is_active' => true
        ]);

        News::create([
            'news_name' => 'Etiam vestibulum a arcu et suscipit. Proin sit amet felis tortor.',
            'description' => 'Etiam vestibulum',
            'image' => 'img-news-3.jpg',
            'is_active' => true
        ]);

        News::create([
            'news_name' => 'Vivamus faucibus laoreet scelerisque',
            'description' => 'Vivamus faucibus laoreet scelerisque',
            'image' => 'img-news-4.jpg',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'Lorem ipsum dolor sit amet, consectetur adipisicing',
            'description' => 'Lorem ipsum dolor s',
            'image' => 't1.jpg',
            'type' => '0',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'The first use of Lorem ipsum is uncertain, though some have suggested the 1500s,',
            'description' => 'Lorem ipsum dolor s',
            'image' => 't2.jpg',
            'type' => '0',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'Mauris quam nunc, finibus maximus bibendum ac, v',
            'description' => 'Lorem ipsum dolor s',
            'image' => 't3.jpg',
            'type' => '0',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'Phasellus nec lectus non ex euismod auctor. ',
            'description' => 'Lorem ipsum dolor s',
            'image' => 't4.jpg',
            'type' => '0',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'Vestibulum egestas bibendum massa,',
            'description' => 'Lorem ipsum dolor s',
            'image' => 't5.jpg',
            'type' => '0',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'porttitor hendrerit mauris hendrerit sed.',
            'description' => 'Lorem ipsum dolor s',
            'image' => 't6.jpg',
            'type' => '0',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 1',
            'image' => 'gallery1.jpg',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 2',
            'image' => 'gallery2.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 3',
            'image' => 'gallery3.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 4',
            'image' => 'gallery4.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 5',
            'image' => 'gallery5.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 6',
            'image' => 'gallery6.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 7',
            'image' => 'gallery7.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 8',
            'image' => 'gallery8.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 9',
            'image' => 'gallery9.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 10',
            'image' => 'gallery10.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 11',
            'image' => 'gallery11.png',
            'type' => '1',
            'is_active' => true
        ]);

        Tournament::create([
            'title' => 'gallery 12',
            'image' => 'gallery12.png',
            'type' => '1',
            'is_active' => true
        ]);

        Sponsors::create([
            'title' => 'Sponsors-1',
            'image' => 'sponsor-1.png',
            'order' => '1',
            'is_active' => true
        ]);

        Sponsors::create([
            'title' => 'Sponsors-2',
            'image' => 'sponsor-2.png',
            'order' => '2',
            'is_active' => true
        ]);

        Sponsors::create([
            'title' => 'Sponsors-3',
            'image' => 'sponsor-3.png',
            'order' => '3',
            'is_active' => true
        ]);

        Sponsors::create([
            'title' => 'Sponsors-4',
            'image' => 'sponsor-4.png',
            'order' => '4',
            'is_active' => true
        ]);

        Sponsors::create([
            'title' => 'Sponsors-5',
            'image' => 'sponsor-5.png',
            'order' => '5',
            'is_active' => true
        ]);

        AboutUs::create([
            'body' => '<p style="font-family: Amiko, sans-serif; font-size: 18px;">In 2015, cricket in Fort McMurray, Alberta continues under the auspices of the Northern Alberta Cricket Association (NACA). A name change instituted in 2015 from the previously used “Fort McMurray Cricket Club” reflected the league’s ambition to integrate into its province’s cricket structure and compete both within and beyond Alberta. To this end, NACA have sought and obtained provisional membership in the Alberta Cricket Association. Already, NACA’s best have hosted and won the inaugural Champions trophy featuring opponents from Calgary, Saskatchewan and Grande Prairie. In August, Ft McMurray travelled to participate in the Red Deer Cup, meeting the teams from Calgary, Edmonton and host city. Again, Ft McMurray prevailed in 2015 and repeat history in 2022 with record breaking Canada wide highest run scored in any ACA hosted T-20 event and won tournament with flying colors.</p><p style="font-family: Amiko, sans-serif; font-size: 18px;">Locally, Syncrude Athletic Park has been the home of cricket since 2007 with an astroturf wicket installed in 2013.</p><p style="font-family: Amiko, sans-serif; font-size: 18px;">The league’s modern history extends back to the late 1990s but it seems cricket was played in Ft McMurray as early and the 1960s. Over 100 cricketers split amongst five teams participate in the NACA 40-over and T20 formats. 2015, the ‘Snyepers’ team captured both titles. It is hoped that a place in the China Rose Cup, Alberta’s club championship, will be extended to Ft McMurray’s champions. It would be yet another achievement for this cricket outpost in Alberta’s north.</p>',
            'image' => 'about-us.png',
            'president' => 'Raheel Joseph',
            'vice_president' => 'Zahid Ali',
            'treasurer' => 'Ihtesham Sikander',
            'general_secretary' => 'Chirag Parikh',
            'league_manager' => 'Sarmad Abbas',
            'latitude' => '56.75269252923149',
            'longitude' => '-111.48132648411813',
        ]);
    }
}
