<?php $section = $tmf->section('copyright') ?>

<?php $row = $tmf->row('copyright', 1050) ?>

<?php $row->cell(24) ?>
<div class="desktop-view">
  <?php $tmf->module('copyright')->render() ?>
</div>
<div class="mobile-view copyright-mobile">
  <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/images/footer-legal.jpg?ver=1.0.1" alt="" style="max-width: 100%; margin: 0 auto; display: block;">
  <!--<p>
    Advertising Materials / Legal Advertising. Any testimonials or stories set forth on this website are by actual clients and their families. Such 
    testimonials or stories are provided for informational purposes only and are not to be considered as a promise or guarantee as to the outcome of 
    your specific case and may not be typical. Every case presents unique facts and circumstances. Your case and expected outcome will likely
    differ from the facts of the cases listed. The only way to properly evaluate your case is to consult with a qualified personal injury attorney.
  </p>
  <p>
    Aggregate ratings are compiled by a third party from all actual reviews posted by users on Google, Facebook, AVVO™, & the Better Business Bureau
    and are current as of <?php echo date("m/d/Y") . "."; ?>
  </p>-->
  <p class="terms-privacy" style="text-align: center;">© 2022 Wruck Paupore PC<br />
    <a href="http://wplaw.local/terms-of-service/">Terms of Service</a>  |  <a href="http://wplaw.local/privacy-policy/">Privacy Policy</a>
  </p>
</div>

<?php $row->close() ?>

<?php $section->close() ?>