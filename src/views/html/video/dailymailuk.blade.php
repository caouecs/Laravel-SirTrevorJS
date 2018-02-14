@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe frameborder="0" width="698" height="503" scrolling="no" id="molvideoplayer" title="MailOnline Embed Player"
    src="https://www.dailymail.co.uk/embed/video/{!! $remote !!}.html" ></iframe>
@stop
