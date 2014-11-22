@extends('sirtrevorjs::video.base')

@section('video')
  <iframe frameborder="0" width="698" height="503" scrolling="no" id="molvideoplayer" title="MailOnline Embed Player"
    src="http://www.dailymail.co.uk/embed/video/{{ $remote }}.html" ></iframe>
@end
