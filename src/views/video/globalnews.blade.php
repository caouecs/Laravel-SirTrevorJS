@extends('sirtrevorjs::video.base')

@section('video')
  <iframe src="http://globalnews.ca/video/embed/{{ $remote }}/" width="670" height="437" frameborder="0" allowfullscreen></iframe>
@end
