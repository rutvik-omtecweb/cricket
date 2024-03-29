<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\News;
use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Models\Event;
use SimpleXMLElement;
use App\Models\Banner;
use App\Models\Player;
use App\Models\AboutUs;
use App\Models\CmsPage;
use App\Models\Payment;
use App\Models\Sponsors;
use App\Models\OuterNews;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\HomepageContent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function home()
    {
        $banners = Banner::active()->latest()->orderBy('order')->limit(5)->get();
        $home_page_content = HomepageContent::first();
        $news_list = News::active()->latest()->limit(3)->get();
        $past_tournaments = Tournament::active()->where('type', 0)->latest()->limit(7)->get();
        $sponsors = Sponsors::active()->orderBy('order')->latest()->limit(6)->get();
        return view('frontend.home', compact('banners', 'home_page_content', 'news_list', 'past_tournaments', 'sponsors'));
    }

    public function aboutUS()
    {
        $about_us = AboutUs::first();
        return view('frontend.about_us', compact('about_us'));
    }

    public function memberTermsCondition()
    {
        $url = "/member_terms_condition";
        $cms = CmsPage::where('url', $url)->get();
        return response()->json([
            'cms' => $cms,
        ]);
    }

    public function byLaws()
    {
        $cms = CmsPage::where('slug', 'by-laws')->first();
        return view('frontend.by_laws', compact('cms'));
    }

    public function leagueRules()
    {
        $cms = CmsPage::where('slug', 'league-rules')->first();
        return view('frontend.league_rules', compact('cms'));
    }

    public function photoGallery()
    {
        $photos = Tournament::where('type', '1')->active()->latest()->get(); //list photos
        return view('frontend.photo_gallery', compact('photos'));
    }

    public function newsDetail(Request $request, $id)
    {
        $news = News::findOrFail($id);
        $news_list = News::where('id', '!=', $id)->active()->latest()->limit(4)->get();
        return view('frontend.news_detail', compact('news', 'news_list'));
    }

    public function cmsTerm(Request $request)
    {
        $cms = CmsPage::where('slug', 'terms_of_user')->first();
        return view('cms', compact('cms'));
    }

    public function cmsPages(Request $request, $id)
    {
        $cms = CmsPage::where('id', $id)->first();
        return view('cms', compact('cms'));
    }

    public function cmsPrivacy(Request $request)
    {
        $cms = CmsPage::where('slug', 'privacy_policy')->first();
        return view('cms', compact('cms'));
    }

    public function teamList(Request $request)
    {
        $user_id = Auth::user()->id;
        $team = Team::where('user_id', $user_id)->active()->first();
        $team_members = TeamMember::where('team_id', $team->id)->get();
        return view('frontend.team_list', compact('team', 'team_members'));
    }

    public function teamDetails($id)
    {
        $team = Team::where('id', $id)->first();
        $team_members = TeamMember::where('team_id', $id)->get();
        return view('frontend.team_detail', compact('team', 'team_members'));
    }

    public function memberList(Request $request)
    {
        $members = User::role('member')->with('roles')->active()->verify()->approve()->get();

        //here check if member is already exist
        if (auth()->check()) {
            $is_member =  User::role('member')->with('roles')->active()->verify()->approve()->where('id', auth()->user()->id)->first();
        } else {
            $is_member = null;
        }

        return view('frontend.member_list', compact('members', 'is_member'));
    }

    public function search($keyword)
    {
        $value = $keyword;
        $news = News::query();
        if ($value) {
            $records = $news
                ->where('news_name', 'LIKE', '%' . $value . '%')->orWhere('description', 'LIKE', '%' . $value . '%');
        }

        $record_data = $records->active()->get();

        return response()->json([
            'status' => true,
            'data' => $record_data,
            'message' => 'Data retrieve successfully.',
        ]);
    }

    // public function newsList()
    // {
    //     $rssFeedUrls = [
    //         'https://www.espn.com/espn/rss/news',
    //         'https://www.espn.com/espn/rss/nfl/news',
    //         'https://www.espn.com/espn/rss/nba/news',
    //         'https://www.espn.com/espn/rss/mlb/news',
    //         'https://www.espn.com/espn/rss/nhl/news',
    //     ];

    //     $rssItems = [];

    //     foreach ($rssFeedUrls as $rssFeedUrl) {
    //         $response = Http::withoutVerifying()->get($rssFeedUrl);

    //         if ($response->successful()) {
    //             $xml = new SimpleXMLElement($response->body());

    //             foreach ($xml->channel->item as $item) {
    //                 $title = (string) $item->title;
    //                 $link = (string) $item->link;
    //                 $description = (string) $item->description;

    //                 $image = null;
    //                 foreach ($item->enclosure as $enclosure) {
    //                     if (isset($enclosure['url'])) {
    //                         $image = (string) $enclosure['url'];
    //                         break;
    //                     }
    //                 }

    //                 $rssItems[] = [
    //                     'title' => $title,
    //                     'link' => $link,
    //                     'description' => $description,
    //                     'image' => $image,
    //                 ];
    //             }
    //         }
    //     }
    //     $news = News::active()->get();
    //     return view('frontend.news', compact('news', 'rssItems'));
    // }
    public function newsList()
    {
        // Get the first record from the OuterNews table
        $outerNews = OuterNews::first();

        // Check if a record exists and the link is not empty
        if ($outerNews && !empty($outerNews->link)) {
            // If a record exists and the link is not empty, get the RSS feed URL and limit
            $rssFeedUrl = $outerNews->link;
            $limit = $outerNews->limit;

            // Initialize an empty array to store RSS items
            $rssItems = [];

            // Fetch the RSS feed
            $response = Http::withoutVerifying()->get($rssFeedUrl);

            // Check if the response is successful
            if ($response->successful()) {
                // Parse the XML response
                $xml = new SimpleXMLElement($response->body());

                // Counter for limiting the number of items fetched
                $count = 0;

                // Iterate through each item in the RSS feed
                foreach ($xml->channel->item as $item) {
                    // Break the loop if the limit is reached
                    if ($count >= $limit) {
                        break;
                    }

                    // Extract necessary information from the item
                    $title = (string) $item->title;
                    $link = (string) $item->link;
                    $description = (string) $item->description;

                    // Initialize the image variable
                    $image = null;

                    // Check for the presence of enclosure (image)
                    foreach ($item->enclosure as $enclosure) {
                        if (isset($enclosure['url'])) {
                            // If image URL is found, assign it to the $image variable
                            $image = (string) $enclosure['url'];
                            break;
                        }
                    }

                    // Add the item to the $rssItems array
                    $rssItems[] = [
                        'title' => $title,
                        'link' => $link,
                        'description' => $description,
                        'image' => $image,
                    ];

                    // Increment the counter
                    $count++;
                }
            }
        } else {
            // If no record exists or link is empty, set $rssItems to an empty array
            $rssItems = [];
        }

        // Assuming News is an Eloquent model, retrieve active news items
        $news = News::active()->get();

        // Pass the news items and RSS items to the view
        return view('frontend.news', compact('news', 'rssItems'));
    }

    public function loadMoreImages(Request $request)
    {
        $page = $request->input('page');
        $perPage = 4; // Change this value as needed
        $offset = ($page - 1) * $perPage;

        // Fetch additional images from wherever they are stored
        $additionalImages = []; // Fetch additional images based on your logic

        return view('partials.image_cards', compact('additionalImages'))->render();
    }

    public function eventList()
    {
        $today = Carbon::today();

        // Retrieve active events that have an end date after today
        $events = Event::active()->where('end_date', '>', $today)->get();
        return view('frontend.event', compact('events'));
    }

    public function eventDetail(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        if (auth()->check()) {
            $ch_player = Player::where('user_id', auth()->user()->id)
                ->where('status', 'success')
                ->first();
        } else {
            $ch_player = null; // or any other handling you want
        }
        return view('frontend.event_detail', compact('event', 'ch_player'));
    }

    public function becomePlayer(Request $request)
    {
        if (auth()->check()) {
            $user_id = Auth::user()->id;
        } else {
            $user_id = null;
        }
        $player_payment = Payment::where('title', 'Player Fees')->first();
        $players = Player::with('user')->where('status', 'success')->get();
        $existing_player = Player::where('user_id', $user_id)->where('status', 'success')->first();
        return view('frontend.player', compact('player_payment', 'user_id', 'players', "existing_player"));
    }
}
