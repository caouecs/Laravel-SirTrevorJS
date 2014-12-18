<blockquote class="twitter-tweet tw-align-center">
  <p>{{ $data['text'] }}</p>
  &mdash; {{ $data['user']['name'] }} (@{{ $data['user']['screen_name'] }})
  <a href="{{ $data['status_url'] }}" data-datetime="{{ $data['created_at'] }}">
    {{ $data['created_at'] }}
  </a>
</blockquote>
