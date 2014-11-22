<?php
/**
 * Laravel4-SirTrevorJs
 *
 * @link https://github.com/caouecs/Laravel4-SirTrevorJS
 */

namespace Caouecs\Sirtrevorjs\Converter;

/**
 * Videos for Sir Trevor Js
 *
 * @package Caouecs\Sirtrevorjs\Converter
 */
class VideoConverter
{
    /**
     * Provider name
     *
     * @access protected
     * @var string
     */
    protected $provider = null;

    /**
     * Remote id
     *
     * @access protected
     * @var string
     */
    protected $remote_id = null;

    /**
     * Caption
     *
     * @access protected
     * @var string
     */
    protected $caption = null;

    /**
     * Javascript
     *
     * @access protected
     * @var array
     */
    protected $codejs = array(
        "vine" => '<script async src="http://platform.vine.co/static/scripts/embed.js" charset="utf-8"></script>'
    );

    /**
     * Providers with code
     *
     * @access protected
     * @var array
     */
    protected $providers = array(
        /**
         * Youtube
         */
        "youtube" => '<iframe width="580" height="320" src="//www.youtube.com/embed/{remote}" frameborder="0" allowfullscreen></iframe>',
        /**
         * Vimeo
         */
        "vimeo" => '<iframe src="//player.vimeo.com/video/{remote}?title=0&amp;byline=0" width="580" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>',
        /**
         * Dailymotion
         */
        "dailymotion" => '<iframe frameborder="0" width="580" height="320" src="//www.dailymotion.com/embed/video/{remote}"></iframe>',
        /**
         * Vine
         */
        "vine" => '<iframe class="vine-embed" src="//vine.co/v/{remote}/embed/simple" width="580" height="320" frameborder="0"></iframe>',
        /**
         * Metacafe
         */
        "metacafe" => '<iframe src="http://www.metacafe.com/embed/{remote}/" width="540" height="304" allowFullScreen frameborder=0></iframe>',
        /**
         * Yahoo Video
         */
        "yahoo" => '<iframe width="640" height="360" scrolling="no" frameborder="0" src="http://screen.yahoo.com/embed/{remote}.html" allowfullscreen="true" mozallowfullscreen="true" webkitallowfullscreen="true" allowtransparency="true"></iframe>',
        /**
         * UStream
         */
        "ustream" => '<iframe width="640" height="392" src="http://www.ustream.tv/embed/{remote}?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0 none transparent"></iframe>',
        /**
         * UStream Record
         */
        "ustreamrecord" => '<iframe width="640" height="392" src="http://www.ustream.tv/embed/recorded/{remote}?v=3&amp;wmode=direct" scrolling="no" frameborder="0" style="border: 0 none transparent"></iframe>',
        /**
         * Veoh
         */
        "veoh" => '<object width="640" height="532" id="veohFlashPlayer" name="veohFlashPlayer"><param name="movie" value="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1444&amp;permalinkId={remote}&amp;player=videodetailsembedded&amp;videoAutoPlay=0&amp;id=anonymous"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.veoh.com/swf/webplayer/WebPlayer.swf?version=AFrontend.5.7.0.1444&amp;permalinkId={remote}&amp;player=videodetailsembedded&amp;videoAutoPlay=0&amp;id=anonymous" type="application/x-shockwave-flash" allowscriptaccess="always" allowfullscreen="true" width="640" height="532" id="veohFlashPlayerEmbed" name="veohFlashPlayerEmbed"></embed></object>',
        /**
         * Vevo
         */
        "vevo" => '<iframe width="575" height="324" src="http://cache.vevo.com/m/html/embed.html?video={remote}" frameborder="0" allowfullscreen></iframe>',
        /**
         * AOL Video
         */
        "aol" => '<script type="text/javascript" src="http://pshared.5min.com/Scripts/PlayerSeed.js?sid=281&amp;width=560&amp;height=345&amp;playList={remote}"></script>',
        /**
         * Metatube
         */
        "metatube" => '<iframe width="640" height="480" src="http://www.metatube.com/en/videos/{remote}/embed/" frameborder="0" allowfullscreen></iframe>',
        /**
         * Wat TV
         */
        "wat" => '<iframe src="http://www.wat.tv/embedframe/{remote}" frameborder="0" style="width:640px;height: 360px"></iframe>',
        /**
         * DailyMail UK
         */
        "dailymailuk" => '<iframe frameborder="0" width="698" height="503" scrolling="no" id="molvideoplayer" title="MailOnline Embed Player" src="http://www.dailymail.co.uk/embed/video/{remote}.html" ></iframe>',
        /**
         * Canal Plus
         */
        "cplus" => '<iframe width="640" height="360" frameborder="0" scrolling="no" src="http://player.canalplus.fr/embed/?param=cplus&amp;vid={remote}"></iframe>',
        /**
         * France Television
         */
        "francetv" => '<iframe frameborder="0" width="640" height="360" src="http://api.dmcloud.net/player/embed/{remote}?exported=1"></iframe>',
        /**
         * Zoomin.tv
         */
        "zoomin" => '<iframe src="http://blackbird.zoomin.tv/players/.pla?pid=corporatefr&amp;id={remote}&amp;w=655&amp;h=433" style="width:655px; height:433px; border:none; overflow:hidden;" frameborder="0" scrolling="no" allowtransparency="yes"></iframe>',
        /**
         * Global News
         */
        "globalnews" => '<iframe src="http://globalnews.ca/video/embed/{remote}/" width="670" height="437" frameborder="0" allowfullscreen></iframe>',
        /**
         * NHL
         */
        "nhl" => '<iframe src="http://video.nhl.com/videocenter/embed?playlist={remote}" frameborder="0" width="640" height="395"></iframe>',
        /**
         * Livestream
         */
        "livestream" => '<iframe src="http://new.livestream.com/accounts/{remote}/player?autoPlay=false&amp;height=360&amp;mute=false&amp;width=640" width="640" height="360" frameborder="0" scrolling="no"></iframe>',
        /**
         * Ooyala
         */
        "ooyala" => '<script height="349px" width="620px" src="http://player.ooyala.com/iframe.js#pbid={remote}"></script>',
        /**
         * NBC Bay Area
         */
        "nbcbayarea" => '<script type="text/javascript" charset="UTF-8" src="http://www.nbcbayarea.com/portableplayer/?cmsID={remote}&amp;origin=nbcbayarea.com&amp;sec=news&amp;subsec=sports&amp;width=600&amp;height=360"></script>'
    );

    /**
     * Construct
     *
     * @access public
     * @param array $data Data of video
     */
    public function __construct($data)
    {
        if (!is_array($data) || !isset($data['source']) || !isset($data['remote_id'])) {
            throw new Exception("Need an array with provider and remote_id", 1);
        }

        $this->provider = $data['source'];
        $this->remote_id = $data['remote_id'];
        $this->caption = isset($data['caption']) ? $data['caption'] : null;
    }

    /**
     * Js Code
     *
     * @access public
     * @return string
     */
    public function jscode(&$arr)
    {
        if (isset($this->codejs[$this->provider])) {
            $arr[$this->provider] = $this->codejs[$this->provider];
        }
    }

    /**
     * Render of video tag
     *
     * @access public
     * @return string
     */
    public function render()
    {
        if (isset($this->providers[$this->provider])) {
            return View::make("sirtrevorjs::video.base", array(
                "video" => str_replace("{remote}", $this->remote_id, $this->providers[$this->provider]),
                "caption" => $this->caption
            ));
        }

        return null;
    }
}
