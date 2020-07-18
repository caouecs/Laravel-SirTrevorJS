@extends('sirtrevorjs::html.video.base')

@section('video')
  <iframe width="698" height="503" id="molvideoplayer" title="MailOnline Embed Player"
    src="https://www.dailymail.co.uk/embed/video/{!! $remote !!}.html" ></iframe>
@stop
