<?php

use App\Models\CmsPage;
use App\Models\GeneralSetting;
use App\Models\LiveScore;

function general_setting()
{
    $general_setting = GeneralSetting::first();
    return $general_setting;
}

function cms()
{
    $slug = ['by-laws', 'league-rules', 'member_terms_condition'];
    $cms = CmsPage::whereNotIn('slug', $slug)->active()->get();
    return $cms;
}

function live_score()
{
    $live_score = LiveScore::first();
    return $live_score;
}
