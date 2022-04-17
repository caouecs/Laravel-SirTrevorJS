<figure data-feedback="fb:likes, fb:comments">
  <img src="{!! $url !!}" alt="{!! $alt ?? '' !!}" />

@if (! empty($text))
  <figcaption>{!! $text !!}</figcaption>
@endif
</figure>
