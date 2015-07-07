<script type="text/javascript">
$(function(){

@if ($config['language'] != "en" && $config['version'] == '0.3')
  SirTrevor.LANGUAGE = '{!! $config['language'] !!}';
@elseif ($config['language'] != "en")
  SirTrevor.config.language = '{!! $config['language'] !!}';
@endif

  SirTrevor.setDefaults({uploadUrl: '{!! $config['uploadUrl'] !!}'});
  SirTrevor.setBlockOptions('Tweet', {
    fetchUrl: function(tweetID) {
        return '{!! $config['tweetUrl'] !!}?tweet_id=' + tweetID;
    }
  });
  window.editor = new SirTrevor.Editor({
    el: $('.{!! $config['class'] !!}'),
    blockTypes: [{!! $config['blocktypes'] !!}]
  });
});
</script>
