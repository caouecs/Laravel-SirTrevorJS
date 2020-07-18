<figure class="op-interactive">
  <iframe title="{!! $data['title'] ?? '' !!}">
    <div class="fb-post" data-href="https://www.facebook.com/{!! $data['author'] !!}/posts/{!! $data['remote_id'] !!}"
      data-width="466" style="overflow-x: hidden;overflow-y:hidden;max-width: 100%;">
      <div class="fb-xfbml-parse-ignore">
        <a href="https://www.facebook.com/{!! $data['author'] !!}/posts/{!! $data['remote_id'] !!}">Post</a>
        by <a href="https://www.facebook.com/{!! $data['author'] !!}">{!! $data['author'] !!}</a>.
      </div>
    </div>
  </iframe>
</figure>
