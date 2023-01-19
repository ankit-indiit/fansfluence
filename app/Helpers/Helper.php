<?php
use App\Models\User;
use App\Models\Category;
use App\Models\InfluencerPersonalize;
use App\Models\AccountNotification;
use App\Models\StarCollection;
use App\Models\RecentlyViewed;
use App\Models\Review;
use App\Models\StaredInfluencer;
use App\Models\DeliverySpeed;
use App\Models\PaymentMethod;
// use Auth;

function getUserImageById($id)
{
	return User::where('id', $id)->pluck('image')->first();
}

function getUserNameById($id)
{
	return User::where('id', $id)->pluck('name')->first();
}

function getUserProfilePic($id)
{
	$user = User::findOrFail($id);
	if (isset($user->image_name)) {
		return '<img alt="avatar" src="'.$user->image.'">';
	} else {
		return '<img alt="avatar" src="'.asset("https://ui-avatars.com/api/?name=".$user->name."").'">';
	}
}

function getUserById($id)
{
	return User::findOrFail($id);
}

function getAllCategory()
{
	return Category::all();
}

function reachingOutUsOptions()
{
	if (\Auth::check() && \Auth::user()->hasRole('influencer')) {
		$options = [
			'' => 'Please select',
			'reason-issue' => 'I have an issue',
			'reason-question' => 'I have a question',
		];
	} else {
		$options = [
			'' => 'Please select',
			'reason-issue' => 'I have an issue',
			'reason-question' => 'I have a question',
			'reason-enroll' => 'Enroll as a Star'
		];
	}
	return $options;
}

function primaryPlatformOptions()
{
	return [
		'' => 'Please select',
		'youtube' => 'Youtube',
		'tiktok' => 'Tiktok',
		'twitch' => 'Twitch'
	];
}

function DNoneClass($category, $id = '')
{
	$userId = $id == '' ? Auth::id() : $id;
	$personalize = InfluencerPersonalize::where('influencer_id', $userId)->first();
	switch ($category) {
	    case 'photo':
	        if (!empty($personalize->photo_with_watermark) || !empty($personalize->photo_with_out_watermark)) {
	            return '';
	        } else {
	            return 'd-none';
	        }
	    break;
	    case 'video':
	        if (!empty($personalize->video_with_watermark) || !empty($personalize->video_with_out_watermark)) {
	            return '';
	        } else {
	            return 'd-none';
	        }
	    break;
	    case 'media':
	        if (!empty($personalize->facebook_price) || !empty($personalize->instagram_price) || !empty($personalize->twitter_price)) {
	            return '';
	        } else {
	            return 'd-none';
	        }
	    break;	    
    }
}

function checkedAttr($category)
{
	$personalize = InfluencerPersonalize::where('influencer_id', Auth::id())->first();
	switch ($category) {
	    case 'photo':
	        if ($personalize->photo_with_watermark != '' || $personalize->photo_with_out_watermark != '') {
	            return 'checked';
	        } else {
	            return '';
	        }
	        break;
	    case 'video':	        
	        if ($personalize->video_with_watermark != '' || $personalize->video_with_out_watermark != '') {
	            return 'checked';
	        } else {
	            return '';
	        }	        
	        break;
	    case 'media':	        
	        if ($personalize->facebook_price != '' || $personalize->instagram_price != '' || $personalize->twitter_price != '') {
	            return 'checked';
	        } else {
	            return '';
	        }
	        break;
	    default:
	        return '';
	        break;
    }
}

function price($type)
{
	$personalize = InfluencerPersonalize::where('influencer_id', Auth::id())->first();
	switch ($type) {
        case 'photoWaterMark':
            return $personalize->photo_with_watermark;
            break;
        case 'photoWithOutWaterMark':
            return $personalize->photo_with_out_watermark;
            break;
        case 'videoWaterMark':
            return $personalize->video_with_watermark;
            break;
        case 'videoWithOutWaterMark':
            return $personalize->video_with_out_watermark;
            break;
        case 'facebook':
            return $personalize->facebook_price;
            break;
        case 'instagram':
            return $personalize->instagram_price;
            break;
        case 'twitter':
            return $personalize->twitter_price;
            break;
        
        default:
            return '';
            break;
    }
}

function getAllNotifications()
{
	return \Auth::user()->unreadNotifications->take(5);
}

function orderUpdateAlert()
{
	return AccountNotification::select('id', 'notification', 'email', 'mobile')
		->where('user_id', Auth::id())
		->where('name', 'order_update')
		->first();
}

function orderFinishedAlert()
{
	return AccountNotification::select('id', 'notification', 'email', 'mobile')
		->where('user_id', Auth::id())
		->where('name', 'order_finished')
		->first();
}

function eventDiscountAlert()
{
	return AccountNotification::select('id', 'notification', 'email', 'mobile')
		->where('user_id', Auth::id())
		->where('name', 'event_discount')
		->first();
}

function getCollections()
{
	return StarCollection::select('id', 'name')
		->where('user_id', Auth::id())
		->get();
}

function getInfluencers($type)
{
	$users = User::role('influencer')
        ->where('id', '!=', Auth::id())
        ->where('status', '1');
	switch ($type) {
		case 'youtubers':
			$users->where('primary_platform', 'youtube');
		break;
		case 'tiktok':
			$users->where('primary_platform', 'tiktok');
		break;
		case 'twitch':
			$users->where('primary_platform', 'twitch');
		break;
		case 'recentlyViewed':
			$ids = RecentlyViewed::where('user_id', Auth::id())
				->pluck('influencer_id')
				->toArray();
			$users->whereIn('id', $ids);
		break;
		case 'trending':
			$influencerIds = Review::where('rating', 5)
		        ->pluck('influencer_id');
		    $users->whereIn('id', $influencerIds)
		        ->orderBy('id', 'DESC');
		break;
		case 'recommended':
			$users->orderBy('updated_at');
		break;
		case 'recentlyStarred':
			$collIds = StarCollection::where('user_id', Auth::id())
				->pluck('id');
			$staredIds = StaredInfluencer::whereIn('collection_id', $collIds)
				->pluck('influencer_id');
		    $users->whereIn('id', $staredIds)
		        ->orderBy('id', 'DESC');
		break;
		case 'explore':
			$explore = User::role('influencer')
		        ->where('id', '!=', Auth::id())
		        ->where('status', '1');
			$youtuberIds = $explore->where('primary_platform', 'youtube')
		        ->pluck('id')->toArray();
		    $tiktokrIds = $explore->where('primary_platform', 'tiktok')
		        ->pluck('id')->toArray();
		    $twitchrIds = $explore->where('primary_platform', 'twitch')
		        ->pluck('id')->toArray();
		    $recentlyViewerIds = $explore->orderBy('updated_at')
		        ->pluck('id')->toArray();
		    $trending = Review::where('rating', 5)
		        ->pluck('influencer_id')->toArray();		    
		    $staredIds = StaredInfluencer::pluck('influencer_id')->toArray();
		    $userIds = array_merge($youtuberIds, $tiktokrIds, $twitchrIds, $recentlyViewerIds, $trending, $staredIds);		   
		    $users->whereIn('id', array_unique($userIds));
		break;

	}
	return $users->paginate(20);
}

function siteLogo()
{	
	if (Route::currentRouteName() == 'home') {
        if (Auth::user() && Auth::user()->business == 1) {
            return '<img src="'.asset('assets/img/fansfluence-business-logo.png').'" class="site-logo">';
        } elseif (Session::has('business')) {
        	return '<img src="'.asset('assets/img/fansfluence-business-logo.png').'" class="site-logo">';
        } else {
    	    return '<img src="'.asset('assets/img/logo.png').'" class="site-logo">';
        }
	} else {
		if (Auth::user() && Auth::user()->business == 1) {
			return '<img src="'.asset('assets/img/light-business-logo.png').'" class="site-logo">';
		} elseif (Session::has('business')) {
        	return '<img src="'.asset('assets/img/light-business-logo.png').'" class="site-logo">';
        } else {
    		return '<img src="'.asset('assets/img/logo-2.png').'" class="site-logo">';
		}
	}
}

function bussIcon($userId)
{
	$bussIcon = User::where('id', $userId)
		->pluck('business')
		->first();
	if ($bussIcon == 1) {
        return '<img src="'.asset('assets/img/business-icon.png').'">';
    } else {
        return '';
    }
}

function deliverySpeed()
{
	return DeliverySpeed::select('id', 'estimate')->get();
}

function getPaymentInfo($mode, $type, $key)
{
	return PaymentMethod::where('mode', $mode)->where('type', $type)->pluck($key)->first();
}