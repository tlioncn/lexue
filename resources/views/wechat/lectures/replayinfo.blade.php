<!--
 *
 *
 *   ______                        _____           __
 *  /_  __/__  ____ _____ ___     / ___/__  ______/ /___
 *   / / / _ \/ __ `/ __ `__ \    \__ \/ / / / __  / __ \
 *  / / /  __/ /_/ / / / / / /   ___/ / /_/ / /_/ / /_/ /
 * /_/  \___/\__,_/_/ /_/ /_/   /____/\__,_/\__,_/\____/
 *
 *
 *
 * Filename->lectureinfo.blade.php
 * Project->lexue
 * Description->Breif info of a lecture.
 *
 * Created by DM on 16/9/7 上午6:58.
 * Copyright 2016 Team Sudo. All rights reserved.
 *
-->
@foreach($lectures as $lecture)

    <a href="{{ route('m.students::lectures.show', $lecture->id) }}" class="weui_media_box weui_media_appmsg">
        <div class="weui_media_hd">
            <img class="weui_media_appmsg_thumb" src="{{ $lecture->thumb->url('small') }}" alt="{{ $lecture->name }}">
        </div>
        <div class="weui_media_bd">
            <span class="pricetag">￥{{ number_format($lecture->price, 2) }}</span>
            <span class="badge lexue">回放</span><h4 class="weui_media_title">{{ $lecture->name }}</h4>
            <p class="weui_media_desc">{{ $lecture->start_time->format('Y年n月j日 H:i') }}</p>
            <div class="badgegroup">
                <span class="badge secondary">{{ $lecture->orders->count() }}人已购买</span>
                @if(array_key_exists($lecture->id, $userLecturesList))
                    @if($userLecturesList[$lecture->id] == 1)
                        <span class="badge grey2">已购买</span>
                    @else
                        <span class="badge grey2">已下单</span>
                    @endif
                @endif
            </div>
        </div>
    </a>

@endforeach