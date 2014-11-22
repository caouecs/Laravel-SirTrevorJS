@extends('sirtrevorjs::video.base')

@section('video')
  <iframe width="575" height="324" src="http://cache.vevo.com/m/html/embed.html?video={{ $remote }}" frameborder="0"
    allowfullscreen></iframe>
@end
