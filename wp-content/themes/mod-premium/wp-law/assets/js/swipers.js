// Testimonials slider
const swiperTestimonials = new Swiper('.swiper-reviews', {
  // Optional parameters
  loop: true,
  autoplay: {
    delay: 16000,
  },
  speed: 1200,
  // Default
  slidesPerView: 1,
  spaceBetween: 0,
  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    750: {
      enabled: false,
    }
  }
});


const swiperResults = new Swiper('.swiper-results', {
  // Optional parameters
  loop: true,
  autoplay: {
    delay: 16000,
  },
  speed: 1200,
  // Default
  slidesPerView: 1,
  spaceBetween: 10,
  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    750: {
      enabled: false,
    }
  }
});