@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe loading="lazy" src="https://new.livestream.com/accounts/{!! $remote !!}/player?autoPlay=false&amp;height=360&amp;mute=false&amp;width=640" width="640" height="360" title="{!! $title !!}"></iframe>
@stop
