<figure class="st-image">
  <img src="{!! $url !!}" alt="{!! $text !!}" height="{!! $height !!}" width="{!! $width !!}" />

@if (! empty($text))
  <figcaption>{!! $text !!}</figcaption>
@endif
</figure>
