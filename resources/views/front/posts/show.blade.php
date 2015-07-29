@extends('front.layout')

@section('content')

	<div class="row show-item">
        {!! $post->getMeta('123') !!}
		<!-- posts listing -->
		<div class='col-sm-6 top35'>
		    @if ($youtube_id != "")

		        <iframe  style="display:none;" id="ytplayer" type="text/html" width="100%" height="321"
                  src="//www.youtube.com/embed/{{$youtube_id}}?rel=0&showinfo=0&color=white&iv_load_policy=3"
                                                                      frameborder="0" allowfullscreen></iframe>
                <a href="#videoFrame" id="videoFrame" alt="{!! $post->title !!}" title="{!! $post->title !!}">
                <div class="videoImageFrame" style="background-image: url('{!! $post->getFirstMediaURL( $post->getMediaCollectionName(), 'featured') !!}')">
                    <div class="playButtonContainer">
                        <img src="/images/playButton.png" />
                    </div>
                </div>

                <!--<img src="" alt="{!! $post->title !!}" title="{!! $post->title !!}" />-->
                </a>

            @else
		        <img src="{!! $post->getFirstMediaURL( $post->getMediaCollectionName(), 'featured') !!}" alt="{!! $post->title !!}" title="{!! $post->title !!}" />
		    @endif


			<h2 class="heading3">{!! $post->title !!}</h2>
			<p>{!! $post->description !!}</p>	
		</div>

		<!-- others --> 
		<div class='col-sm-5 col-sm-push-1'>
			@if($related_posts->count())
				@include('front.posts._related_posts')
			@endif
		</div>
	</div>

@stop