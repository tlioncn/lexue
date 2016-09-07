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
 * Filename->index.blade.php
 * Project->lexue
 * Description->This is the view for open lectures.
 *
 * Created by DM on 16/8/5 上午5:26.
 * Copyright 2016 Team Sudo. All rights reserved.
 *
-->
@extends('wechat.layouts.blank')

@section('content')
    <div class="weui_tab lectures_index">
        <div class="weui_navbar">
            <a href="#tab1" class="weui_navbar_item weui_bar_item_on">
                即将开播
            </a>
            <a href="#tab2" class="weui_navbar_item">
                直播中
            </a>
        </div>
        <div class="weui_tab_bd">
            <div id="tab1" class="weui_tab_bd_item weui_tab_bd_item_active">
                <div class="weui_panel weui_panel_access">
                    <div class="weui_panel_bd">
                        @foreach($lectures as $lecture)
                            @if($lecture->not_started)
                                @include('wechat.partials.lecturebrief')
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div id="tab2" class="weui_tab_bd_item">
                <!--
                <article class="weui_article">
                    <section>
                        <p>无正在直播的课程！</p>
                    </section>
                </article>
                -->
                <div id="tab2" class="weui_panel weui_panel_access">
                    <div class="weui_panel_bd">

                        @foreach($lectures as $lecture)
                            @if($lecture->is_live)
                                @include('wechat.partials.lecturebrief')
                            @endif
                        @endforeach

                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection