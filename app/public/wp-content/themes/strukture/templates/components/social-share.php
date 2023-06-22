<?php
$current_url = get_permalink();
$current_title = get_the_title();
$twitter_body = $current_title . ': ' . $current_url;
$twitter_link = "http://twitter.com/intent/tweet?text=Currently reading " . get_the_title() . ";url=" . get_permalink();
$highlight_one = get_field('highlight_color_one', 'option');
$highlight_two = get_field('highlight_color_two', 'option');
?>



<div class="social-share">
    <h6 class="subtitle">Share:</h6>
    <ul class="social-list">
        <li class="facebook-share">
            <a target="_blank" href="<?php echo esc_attr( "https://www.facebook.com/sharer/sharer.php?u={$current_url}" ); ?>" class="pop"><i style="color:<?php echo $highlight_two;?>"  class="fab fa-facebook"></i></a>
        </li>

        <li class="twitter-share">
            <a style="color:<?php echo $highlight_two;?>"  class="fa fa-twitter pop" href= "<?php echo $twitter_link ?>"" target="_blank" rel="noopener noreferrer">
            </a>
        </li>


        <li class="linkedin-share">
            <a target="_blank" href="<?php echo esc_attr( "https://www.linkedin.com/cws/share?url={$current_url}" ); ?>" class="pop"><i style="color:<?php echo $$highlight_two;?>"  class="fab fa-linkedin"></i></a>
        </li>



    </ul>
</div>


