<?php //add email obfuscation function
function email_encrypt_script(){
	wp_enqueue_script( 'team-email', plugin_dir_url( __FILE__ ) . 'team.js', array('jquery') );
}

add_action('wp_footer','email_encrypt_script'); ?>

<?php get_header(); ?>

<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>


<section id='meet-the-team-single'>
   <div class='container'>
     <div class='row'>

  

<div class="col-sm-3 team-contact pull-right">
  
  <?php the_post_thumbnail( 'medium-square-crop', array( 'class' => 'img-responsive' ) ); ?>
 
  <h1 class="team-title entry-title">
    <?php the_title(); ?>
  </h1>  
 
  <h3 class='job-title'>
    <?php the_field('job-title'); ?>
  </h3>

  <div class='team-member-meta'>

    <?php $team_phone = get_field('team-phone'); 
      if(!empty($team_phone)):?>
        <span>
          <i class="fa fa-phone" aria-hidden="true"></i>
          <a href="tel://+1<?php
            $new_team_phone = str_replace( '.', '', $team_phone);//removes . from phone number string
            $new_team_phone = str_replace( '-', '', $new_team_phone);//removes - from phone number string
            $new_team_phone = str_replace( ' ', '', $new_team_phone);
            $new_team_phone = str_replace( ')', '', $new_team_phone);
            $new_team_phone = str_replace( '(', '', $new_team_phone);
            echo $new_team_phone;?>"><?php the_field('team-phone');?>
          </a>
        </span>
    <?php endif; ?>
    
    <?php if(get_field("team-email")){ ?>
    <span>
      <i class="fa fa-envelope" aria-hidden="true"></i>
      <a id='team-email' href='#' style='display:<?php if(!the_field("team-email")){echo "none;";}else{echo "initial;";} ?>'></a>
    </span>
    <?php } ?>
    
    <?php if(get_field("team-vcard")){ ?>
    <span>
      <i class="fa fa-file-text" aria-hidden="true"></i>
      <a href="<?php $vcard = get_field('team-vcard'); echo $vcard['url']; ?>">Download vCard</a>
    </span>
    <?php } ?>
  
  </div>

</div>
<div class="col-sm-9 pull-left">

    <section id="content" role="main">
      
      <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <header class="header">
            <h2 style='color:#333;'>Profile</h2>
        </header>
        <section class="entry-content">
          <?php the_content(); ?>
          <a href="<?php if(get_field('archive-link','option')): the_field('archive-link','option'); else: echo '..'; endif; ?>" class='button back-to-team' style='margin-top:1em;'>&larr; All Team Members</a>
        </section>
      </article>
    </section>
</div>

     </div>
  </div>
</section>


<script type="text/javascript">
  var email_storage = "nospam<?php the_field('team-email'); ?>";
  console.log(email_storage);
</script>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
