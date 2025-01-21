let images = Array();
let ai, slides, cs

document.addEventListener("DOMContentLoaded", ()=>{

    if(document.querySelector('.swiper_photo_galery')){
        new Swiper('.swiper_photo_galery', {
            slidesPerGroup: 1,
            speed: 300,
            a11y: false,
            slideToClickedSlide: true,
            navigation: {
                nextEl: '.phg_swiper_next',
                prevEl: '.phg_swiper_prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 20,
                }
            },
            on: {
                init: function () {
                    ai = this.activeIndex;
                    slides = this.slides;
                    cs = slides[ai];
                    $('.galery_swiper_slide_img').attr('src', cs.querySelector('img').getAttribute('src'));
                    $('.galery_swiper_full_screen_next').on('click', ()=>{
                        if(slides.indexOf(cs) < slides.length){
                            if(this.isEnd && slides.indexOf(cs) <= (slides.length -1) && !$('.galery_swiper_full_screen_next').hasClass("disabled")){
                                cs = slides[slides.indexOf(cs)+1]
                                phgNext();
                                phgChangeSlide(this, cs.querySelector('img'))
                            } 
                            if(!this.isEnd){
                                phgNext();
                                this.slideNext();
                            }
                        }
                    });
                    $('.galery_swiper_full_screen_prev').on('click', ()=>{
                        if(!this.isBeginning){
                            if(slides.indexOf(cs) <= ai){
                                $('.galery_swiper_slide_img').addClass('img_transparent');
                                this.slidePrev();
                                setTimeout(()=>{
                                    $('.galery_swiper_slide_img').removeClass('img_transparent');
                                }, 400)
                            } else {
                                cs = slides[slides.indexOf(cs)-1]
                                phgNext();
                                phgChangeSlide(this, cs.querySelector('img'))
                            }
                        }
                    })
                    if(document.querySelector('.galery_swiper_slide_img')){
                        changephgImgSize (document.querySelector('.galery_swiper_slide_img'))
                    }
                },
                slideChange: function () {
                    ai = this.activeIndex;
                    cs = slides[ai];
                    phgChangeSlide(this, cs.querySelector('img'))
                },
                click: function () {
                    cs = this.clickedSlide
                    $('.galery_swiper_slide_img').attr('src', cs.querySelector("img").getAttribute('src'));
                    if(document.querySelector('.galery_swiper_slide_img')){
                        changephgImgSize (cs.querySelector("img"));
                    }
                }
            }
        })
    }

    $(".swiper_photo_galery .swiper-slide>img").on("click", ()=>{
        $(".galery_swiper_full_screen_wrapper").addClass("shown");
    });

    $(".close_galery_swiper_overlay").on("click", closeGalery);
    $(".galery_swiper_cover").on("click", closeGalery);
    $('.galery_swiper_full_screen_overlay').on('click', (e)=>{
        if(e.target.getAttribute('class') === 'galery_swiper_full_screen'){
            closeGalery();
        }
    });
})
function closeGalery () {
    $(".galery_swiper_full_screen_wrapper").removeClass("shown");
}

function phgChangeSlide (slider, img){
    setTimeout(()=>{
        $('.galery_swiper_slide_img').attr('src', img.getAttribute('src'));
        if(document.querySelector('.galery_swiper_slide_img')){
            changephgImgSize (img);
        }
    }, 200);
    if(slides.indexOf(cs) < (slides.length -1)){
        $('.galery_swiper_full_screen_next').removeClass('disabled')
    } else {
        $('.galery_swiper_full_screen_next').addClass("disabled")
    }
    if(slider.isBeginning){
        $('.galery_swiper_full_screen_prev').addClass('disabled')
    } else {
        $('.galery_swiper_full_screen_prev').removeClass('disabled')
    }
}

function changephgImgSize (el) {
    var dimentions = get_dimensions(el);
    var el_width = dimentions.real_width === 0 ? dimentions.client_width : dimentions.real_width;
    var el_height = dimentions.real_height === 0 ? dimentions.client_height : dimentions.real_height;
    var el_rels = el_width/el_height;
    var max_w = document.querySelector('body').clientWidth * 0.8;
    var max_h = window.innerHeight * 0.8;
    var el_pos_width = max_w;
    var el_pos_height = el_pos_width / el_rels;
    if(el_pos_height > max_h) {
        $('.galery_swiper_slide_img').css('height', max_h+'px');
        $('.galery_swiper_slide_img').css('width', 'auto');
    } else {
        $('.galery_swiper_slide_img').css('width', max_w+'px');
        $('.galery_swiper_slide_img').css('height', 'auto');
    }
}

function phgNext() {
    $('.galery_swiper_slide_img').addClass('img_transparent');
    setTimeout(()=>{
        $('.galery_swiper_slide_img').removeClass('img_transparent');
    }, 400);
    $('.galery_swiper_full_screen_next').removeClass('swiper-button-disabled')
}