@extends('sirtrevorjs::html.video.base')

@section('video')
  <object width="640" height="532" id="veohFlashPlayer" name="veohFlashPlayer">
    <param name="movie"
    value="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1444&amp;permalinkId={!! $remote !!}&amp;player=videodetailsembedded&amp;videoAutoPlay=0&amp;id=anonymous"></param>
    <param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param>
    <embed src="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1444&amp;permalinkId={!! $remote !!}&amp;player=videodetailsembedded&amp;videoAutoPlay=0&amp;id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="532" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed>
  </object>
@stop
