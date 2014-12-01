@extends('sirtrevorjs::video.base')

@section('video')
  <iframe src="http://new.livestream.com/accounts/{{ $remote }}/player?autoPlay=false&amp;height=360&amp;mute=false&amp;width=640" width="640" height="360" frameborder="0" scrolling="no"></iframe>
@stop
