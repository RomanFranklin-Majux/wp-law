<?php
defined('FRAMEWORK_VERSION') or die('No direct access.');
/**
 * This is the top block for every front-end page. 
 * 
 * @package TheModernFirmFramework
 * @category Blocks
 * @author The Modern Firm, LLC <support@themodernfirm.com>
 * @copyright Copyright (c) 2012-2013 The Modern Firm, LLC
 */
?>
<!DOCTYPE html>
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js no-touch ie8"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html <?php language_attributes() ?> class="no-js no-touch"><!--<![endif]-->

    <head>
        <meta name="themodernfirm-framework-version" content="<?php echo FRAMEWORK_VERSION ?>" />
        <meta name="wordpress-version" content="<?php echo WP_VERSION ?>" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="<?php bloginfo('charset'); ?>" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no" />
		<meta name="google-site-verification" content="Nxh94rkKgd3VWgsZYhuZ5gxvCQ7JhpL7YJgfvb55qSA" />
        <link rel="profile" href="http://gmpg.org/xfn/11" />	
		
        <?php $tmf->request()->title(TRUE) ?>
        <?php $tmf->head() ?>
		
		
<!-- Indianapolis Schema -->
	<?php if( is_page( 1523)): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/indianapolis/",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Indianapolis",
        "url":"https://www.wikidata.org/wiki/Q6346"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "9465 Counselors Row",
                        "addressLocality": "Indianapolis",
                        "addressRegion": "IN",
                        "postalCode": "46240"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 39.9250447,
                        "longitude": -86.1009579
                    },
        "priceRange": "Free Consultations",
        "description":"Personal Injury Lawyers serving the citizens of Indianapolis, IN",
        "knowsAbout": "Indianapolis personal injury lawyers, Indianapolis personal injury attorneys",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+Injury+Lawyers/@39.9249387,-86.1009742,15z/data=!4m5!3m4!1s0x0:0xbd9ba3bb0c61f151!8m2!3d39.9249387!4d-86.1009742",
        "telephone":"317-436-1082",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "20", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Indianapolis Personal Injury Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Indianapolis personal injury lawyers",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/indianapolis/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "20",
    "reviewCount": "20"
  },
  "review": {
    "@type": "Review",
    "name": "Michele",
    "reviewBody": "This firm is highly respected due to their diligence and work ethics. Jason Paupore has demonstrated knowledge and determination when fighting for his clients rights. I would not hesitate to hire this firm.",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Michele Montmorency"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
		
<?php if( is_page( 1521)): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/indianapolis/car-accident-lawyers/",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Indianapolis",
        "url":"https://www.wikidata.org/wiki/Q6346"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "9465 Counselors Row",
                        "addressLocality": "Indianapolis",
                        "addressRegion": "IN",
                        "postalCode": "46240"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 39.9250447,
                        "longitude": -86.1009579
                    },
        "priceRange": "Free Consultations",
        "description":"Car accident lawyers serving the citizens of Indianapolis, IN",
        "knowsAbout": "Indianapolis car accident lawyers, Indianapolis car accident attorneys",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+Injury+Lawyers/@39.9249387,-86.1009742,15z/data=!4m5!3m4!1s0x0:0xbd9ba3bb0c61f151!8m2!3d39.9249387!4d-86.1009742",
        "telephone":"317-436-1082",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "20", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Indianapolis Car Accident Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Indianapolis Car Accident lawyers",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/indianapolis/car-accident-lawyers/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "20",
    "reviewCount": "20"
  },
  "review": {
    "@type": "Review",
    "name": "Michele",
    "reviewBody": "This firm is highly respected due to their diligence and work ethics. Jason Paupore has demonstrated knowledge and determination when fighting for his clients rights. I would not hesitate to hire this firm.",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Michele Montmorency"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
		
<?php if( is_page( 1582)): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/indianapolis/brain-injury-attorneys/",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Indianapolis",
        "url":"https://www.wikidata.org/wiki/Q6346"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "9465 Counselors Row",
                        "addressLocality": "Indianapolis",
                        "addressRegion": "IN",
                        "postalCode": "46240"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 39.9250447,
                        "longitude": -86.1009579
                    },
        "priceRange": "Free Consultations",
        "description":"Brain Injury lawyers serving the citizens of Indianapolis, IN",
        "knowsAbout": "Indianapolis brain injury lawyers, Indianapolis brain injury attorneys",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+Injury+Lawyers/@39.9249387,-86.1009742,15z/data=!4m5!3m4!1s0x0:0xbd9ba3bb0c61f151!8m2!3d39.9249387!4d-86.1009742",
        "telephone":"317-436-1082",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "20", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Indianapolis brain injury Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Indianapolis brain injury lawyers",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/indianapolis/brain-injury-attorneys/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "20",
    "reviewCount": "20"
  },
  "review": {
    "@type": "Review",
    "name": "Michele",
    "reviewBody": "This firm is highly respected due to their diligence and work ethics. Jason Paupore has demonstrated knowledge and determination when fighting for his clients rights. I would not hesitate to hire this firm.",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Michele Montmorency"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
		
<?php if( is_page( 1525)): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/indianapolis/nursing-home-neglect-and-injury-lawyers/",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Indianapolis",
        "url":"https://www.wikidata.org/wiki/Q6346"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "9465 Counselors Row",
                        "addressLocality": "Indianapolis",
                        "addressRegion": "IN",
                        "postalCode": "46240"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 39.9250447,
                        "longitude": -86.1009579
                    },
        "priceRange": "Free Consultations",
        "description":"Nursing Home Neglect and Abuse lawyers serving the citizens of Indianapolis, IN",
        "knowsAbout": "Indianapolis Nursing Home Neglect lawyers, Indianapolis Nursing Home Injury attorneys",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+Injury+Lawyers/@39.9249387,-86.1009742,15z/data=!4m5!3m4!1s0x0:0xbd9ba3bb0c61f151!8m2!3d39.9249387!4d-86.1009742",
        "telephone":"317-436-1082",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "20", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Indianapolis Nursing Home Neglect and Injury Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Indianapolis Nursing Home injury lawyers",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/indianapolis/nursing-home-neglect-and-injury-lawyers/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "20",
    "reviewCount": "20"
  },
  "review": {
    "@type": "Review",
    "name": "Michele",
    "reviewBody": "This firm is highly respected due to their diligence and work ethics. Jason Paupore has demonstrated knowledge and determination when fighting for his clients rights. I would not hesitate to hire this firm.",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Michele Montmorency"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
		
<?php if( is_page( 1587)): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/indianapolis/slip-and-fall-attorney/",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Indianapolis",
        "url":"https://www.wikidata.org/wiki/Q6346"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "9465 Counselors Row",
                        "addressLocality": "Indianapolis",
                        "addressRegion": "IN",
                        "postalCode": "46240"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 39.9250447,
                        "longitude": -86.1009579
                    },
        "priceRange": "Free Consultations",
        "description":"Slip and Fall Injury lawyers serving the citizens of Indianapolis, IN",
        "knowsAbout": "Indianapolis Slip and Fall, Indianapolis Slip and Fall Attorneys",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+Injury+Lawyers/@39.9249387,-86.1009742,15z/data=!4m5!3m4!1s0x0:0xbd9ba3bb0c61f151!8m2!3d39.9249387!4d-86.1009742",
        "telephone":"317-436-1082",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "20", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Indianapolis Slip and Fall Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Indianapolis Slip and Fall Attorneys",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/indianapolis/slip-and-fall-attorney/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "20",
    "reviewCount": "20"
  },
  "review": {
    "@type": "Review",
    "name": "Michele",
    "reviewBody": "This firm is highly respected due to their diligence and work ethics. Jason Paupore has demonstrated knowledge and determination when fighting for his clients rights. I would not hesitate to hire this firm.",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Michele Montmorency"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
		
<?php if( is_page( 1592)): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/indianapolis/wrongful-death-attorney//",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Indianapolis",
        "url":"https://www.wikidata.org/wiki/Q6346"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "9465 Counselors Row",
                        "addressLocality": "Indianapolis",
                        "addressRegion": "IN",
                        "postalCode": "46240"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 39.9250447,
                        "longitude": -86.1009579
                    },
        "priceRange": "Free Consultations",
        "description":"Wrongful death lawyers serving the citizens of Indianapolis, IN",
        "knowsAbout": "Indianapolis Wrongful Death Lawyer, Indianapolis Wrongful Death Attorney",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+Injury+Lawyers/@39.9249387,-86.1009742,15z/data=!4m5!3m4!1s0x0:0xbd9ba3bb0c61f151!8m2!3d39.9249387!4d-86.1009742",
        "telephone":"317-436-1082",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "20", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Indianapolis Wrongful Death Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Indianapolis Wrongful Death Attorneys",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/indianapolis/wrongful-death-attorney/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "20",
    "reviewCount": "20"
  },
  "review": {
    "@type": "Review",
    "name": "Michele",
    "reviewBody": "This firm is highly respected due to their diligence and work ethics. Jason Paupore has demonstrated knowledge and determination when fighting for his clients rights. I would not hesitate to hire this firm.",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Michele Montmorency"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
		
<!-- Hammond Schema -->
		
<?php if ( is_page( array( 1529, 1527, 1531))): ?>
<script type="application/ld+json">{"@context":"http://schema.org",
    "@type":"LegalService",
    "url":"https://www.wp-law.com/hammond/",
    "name":"Wruck Paupore PC Injury Lawyers",
        "areaServed":{
        "@type":"City",
        "name":"Hammond",
        "url":"https://www.wikidata.org/wiki/Q856860"},
        "address": {
                        "@type": "PostalAddress",
                        "streetAddress": "275 Joliet St Ste 250",
                        "addressLocality": "Dyer",
                        "addressRegion": "IN",
                        "postalCode": "46311"
                    },
        "geo": {
                         "@type": "GeoCoordinates",
                         "latitude": 41.4937864,
                        "longitude": -87.5176358
                    },
        "priceRange": "Free Consultations",
        "description":"Personal injury and accident lawyers serving the citizens of Hammond, IN",
        "knowsAbout": "Hammond Personal Injury Lawyers, Hammond Personal Injury Attorneys, Hammond Accident Lawyers",
        "paymentAccepted":"Cash, Credit, Debit",
        "image":"https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
        "hasMap":"https://www.google.com/maps/place/Wruck+Paupore+PC+-+Injury+Lawyers/@41.4938703,-87.5207334,17z/data=!3m1!4b1!4m5!3m4!1s0x8811e2201dd6ec6b:0x9d9aec01f600cb3a!8m2!3d41.4940009!4d-87.5185865",
        "telephone":"219-322-1166",
        "aggregateRating": { "@type": "AggregateRating", 
        "bestRating": "5", 
        "worstRating": "1", 
        "ratingCount": "69", 
        "ratingValue": "5" }
        }
    </script> <script type="application/ld+json">{
  "@context": "https://schema.org/", 
  "@type": "Product", 
  "name": "Hammond Personal Injury Lawyers",
  "image": "https://www.wp-law.com/wp-content/uploads/2020/10/logo_1x.png",
  "description": "Hammond Personal Injury Attorneys",
  "brand": "Wruck Paupore PC Injury Lawyers",
  "offers": {
    "@type": "AggregateOffer",
    "url": "https://www.wp-law.com/hammond/",
    "priceCurrency": "USD",
    "lowPrice": "0",
    "offerCount": "1"
  },
  "aggregateRating": {
    "@type": "AggregateRating",
    "ratingValue": "5",
    "ratingCount": "69",
    "reviewCount": "69"
  },
  "review": {
    "@type": "Review",
    "name": "Tanya",
    "reviewBody": "The office staff was very professional and responsive.   Any issue with medical bills they took care of right away and stopped the unwanted calls.  Settled my claim swiftly and painlessly.  Highly recommend!!",
    "reviewRating": {
      "@type": "Rating",
      "ratingValue": "5"
    },
    "author": {"@type": "Person", "name": "Tanya Thompson"},
    "publisher": {"@type": "Organization", "name": "Google"}
  }
}</script>
<?php endif; ?>
	<meta name="google-site-verification" content="BMZ1J86PJVBHeHGOOa5liAzdZNJ5koRXcGyh2W62r94" />
	</head>
	
    <body <?php $tmf->body_css() ?>>

        <div id="tmf-popup-form"> 
            <span class="close"></span>
            <?php $tmf->module('tmf-popup-form')->render() ?>
        </div>
        
        <?php $tmf->block('miscellaneous/print-header')->render() ?>
        <?php $tmf->block('sections/secondary-nav')->render() ?>
        <?php $tmf->block('sections/header-sticky')->render() ?>
        <?php $tmf->block('sections/header-top')->render() ?>
        <?php $tmf->block('sections/header')->render() ?>
        <?php if ($tmf->request()->is_home_page()): ?>         
            <?php $tmf->block('sections/billboard')->render() ?>
        <?php //else : ?>
            <?php //$tmf->block('sections/int-billboard')->render() ?>
        <?php endif; ?>
        
	