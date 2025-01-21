var closeMenuTO, closeMenuTO2, upadeCartTO;
var clientDewiceWidth = matchMedia('(max-width: 1200px)');
var clientDewiceWidthMin = matchMedia('(max-width: 767px)');
var mask, startTouchY, startTouchX, deltaY, singleProdSwiper;
var startStockStatus = $('.stok_wrapper').html();
$(()=>{
    menuChanger (clientDewiceWidth);
    footerChanger(clientDewiceWidth);
    window.addEventListener('resize', ()=>{
        menuChanger(clientDewiceWidth);
        footerChanger(clientDewiceWidth);
        if(!clientDewiceWidth.matches){
            $('.header_content_inner .sub-menu').removeAttr('style');
        }
    })
    if(document.querySelector('.shop_table')){
        changeTableContentWidth();
        window.addEventListener('resize', changeTableContentWidth)
    }
    $('.is-search-input').attr('placeholder', "Поиск");
    $('#header_menu_cart_item_search').on('click', showSearch)
    starFiller ();
    $('.feedback_page_raiting').on('input', starFiller);
    if(document.querySelector('#feedback_page_raiting_textarea_id')){
        document.querySelector('#feedback_page_raiting_textarea_id').addEventListener('input', textAreaValuer);
    }
    $('.feedback_page_form_submit').on('click', chekFeedBackForm);
    $('.feedback_page_form').on('input', clearErrors);
    $('.g-recaptcha').on('click', ()=>{
        document.querySelector('.g-recaptcha .error').remove();
    })
    if(document.querySelector('.wpfFilterDelimeter')){
        document.querySelector('.wpfFilterDelimeter').innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" width="15" height="2" viewBox="0 0 15 2" fill="none"><path d="M0 1L15 1" stroke="#D2D2D2"/></svg>'
    }
    if(document.querySelector('.content_filter')){
        menuMover();
        window.addEventListener('resize', menuMover);
    }
    $('.content_filter_header>img').on('click', ()=>{
        $('.content_filter').slideUp(300);
        $('.content_cover').slideUp(0);
    });
    $('.main_product_content_header_btn').on('click', ()=>{
        $('.content_filter').slideDown(300)
        $('.content_cover').slideDown(0);
    });
    $('.product_sel_heart').on('click', addToFaforite);
    replaceCompareBtn($('.product_btn_compare'), addToCompare, checkIfInCompare, 'Добавить в сравнение');
    replaceCompareBtn($('.single_product_sel_heart'), addToFaforite, checkIfInFavorite, "Добавить в избранное");
    replaceCompareBtn($('.product_sel_heart'), addToFaforite, checkIfInFavorite, "добавить в избранное");
    $('.select_btn').on('click', changeComparision);
    $('.select_btn_wrapper img').on('click', deleteComparision);
    $('#qty').on('input', calcSubTotal);
    $('#packages_counter_input').on('input', calcSubTotalThroughtPackages);
    $('#packages_counter_input_linol').on('input', calcSubTotalThroughtPackagesLinol);
    $('body').on('click', '.prod_params_cuts_width_select', calcSubTotal);
    $('.prod_params_cuts_radio').on('input', cutToFitChanger);
    $('.single_product_swiper .swiper-slide .single_product_slide_img').on('click', openSingleProdGalery)
    $('.close_single_product_swiper_full_screen_overlay').on('click', closeSingleProdGalery)
    $('.single_product_swiper_full_screen_wrapper  .cover').on('click', closeSingleProdGalery)
    
    
    if(document.querySelector('#packages_counter_input')){
        calcSubTotal();
        $('#qty').on('focusout', calcSubTotalThroughtPackages);
    }
    
    if (document.querySelector('.cart_squares')){
        cartMetersCalc();
    }
    if(document.querySelector ('.single_product_swiper_full_screen_wrapper')){
        window.addEventListener ('keyup', sliderKeyPressListener)
    }

    $('body').on('click', '.number-minus', (e)=>{
        $(e.target).next().change()
        $(e.target).trigger('input');
    })
    $('body').on('click', '.number-plus', (e)=>{
        $(e.target).prev().change()
        $(e.target).trigger('input')
    })
    $('body').on('change', '.cart_qty_wrapper input', ()=>{
        clearTimeout(upadeCartTO)
        upadeCartTO = setTimeout(()=>{
            $('[name="update_cart"]').trigger('click')
        }, 500)
    })
    $('.cart_offer_form_button').on('click', submitOffer)
    if(document.querySelector('#cart_offer_form_phone')){
        const element = document.getElementById('cart_offer_form_phone');
        const maskOptions = {
        mask: '+{7}(000)000-00-00'
        };
        mask = IMask(element, maskOptions);
    }
    if(document.querySelector('.feedback_input[name="phone"]')){
        const element = document.querySelector('.feedback_input[name="phone"]');
        const maskOptions = {
        mask: '+{7}(000)000-00-00'
        };
        mask = IMask(element, maskOptions);
    }
    $("#cart_offer_form_phone").on('input', checkPhoneinput)
    $("#cart_offer_form_name, #cart_offer_form_email").on('input', removeErrors)

    $('body').on('click', '.offer_cart', (e)=>{
        e.preventDefault()
        if(!$('.cart_offer_form_wrapper').hasClass('show')){
            $('.cart_offer_form_wrapper').addClass('show')
            window.scrollTo({
                top: 0,
                behavior: 'smooth',
            });
        }
    })
    
    $('.cart_offer_form_img').on('click', ()=>{
        if($('.cart_offer_form_wrapper').hasClass('show')){
            $('.cart_offer_form_wrapper').removeClass('show')
        }
        if($('.cart_cheout_wrapper').hasClass('show')){
            $('.cart_cheout_wrapper').removeClass('show')
        }
    })

    $('.wpfDisplay').on('click', (e)=>{
        $(e.target).parents('.wpfLiLabel').find('[type="checkbox"]').trigger('click')
    })
    
    $('#cart_offer_form_checkbox').on('input', ()=>{
        if(document.querySelector('#cart_offer_form_checkbox').checked){
            $('.cart_offer_form_button').removeAttr('disabled');
        } else {
            $('.cart_offer_form_button').attr('disabled', '');
        }
    })
    
    $('.single_product_swiper_full_screen').on('click', (e)=>{
        if(e.target.getAttribute('class') === 'single_product_swiper_full_screen'){
            closeSingleProdGalery();
        }
    });
    
    $('.single_product_swiper_slide_img').on('touchstart', (e)=>{
        startTouchX = e.originalEvent.changedTouches[0].clientX;
        startTouchY = e.originalEvent.changedTouches[0].clientY;
    });
    $('.single_product_swiper_slide_img').on('touchend', ()=>{
        if(deltaY > 50){
            if(!singleProdSwiper.isEnd){
                $('.single_product_swiper_slide_img').addClass('img_transparent');
                singleProdSwiper.slideNext();
                setTimeout(()=>{
                    $('.single_product_swiper_slide_img').removeClass('img_transparent');
                }, 400);
                $('.single_product_swiper_full_screen_next').removeClass('swiper-button-disabled')
            }
        }
        if(deltaY < -50){
            if(!singleProdSwiper.isBeginning){
                $('.single_product_swiper_slide_img').addClass('img_transparent');
                singleProdSwiper.slidePrev();
                setTimeout(()=>{
                    $('.single_product_swiper_slide_img').removeClass('img_transparent');
                }, 400)
            }
        }
    });
    $('.single_product_swiper_slide_img').on('touchmove', scroll)

    //Swiper index page
const swiper = new Swiper('.index_large_swiper', {
    slidesPerGroup: 1,
    slidesPerView: 1,
    speed: 300,
    pagination: {
        el: '.swiper-pagination',
        type: 'bullets',
        clickable: true,
        // dynamicBullets: true,
    },
    navigation: {
        nextEl: '.index_swiper_next',
        prevEl: '.index_swiper_prev',
    },
  });

  new Swiper('.feedback_page_cards', {
    slidesPerGroup: 3,
    slidesPerView: 3,
    speed: 300,
    navigation: {
        nextEl: '.feedback_page_swiper_next',
        prevEl: '.feedback_page_swiper_prev',
    },
    breakpoints: {
        0: {
            slidesPerGroup: 1,
            slidesPerView: 1,
            spaceBetween: 15
        },
        768: {
            slidesPerGroup: 2,
            slidesPerView: 2,
            spaceBetween: 15
        },
        1200: {
            slidesPerGroup: 3,
            slidesPerView: 3,
            spaceBetween: 20
        }
    }
  })

  var controlled = new Swiper('.product_collection_swiper', {
    slidesPerGroup: 1,
    slidesPerView: 1,
    slideToClickedSlide: true,
    speed: 300,
    navigation: {
        nextEl: '.product_cats_swiper_next',
        prevEl: '.product_cats_swiper_prev',
    }
  })

  var controler = new Swiper('.product_collection_swiper_controller', {
    speed: 300,
    slideToClickedSlide: true,
    navigation: {
        nextEl: '.product_cats_swiper_next',
        prevEl: '.product_cats_swiper_prev',
    },
    breakpoints: {
        0: {
            slidesPerGroup: 1,
            slidesPerView: 2,
            spaceBetween: 15
        },
        768: {
            slidesPerGroup: 1,
            slidesPerView: 3,
            spaceBetween: 15
        },
        1200: {
            slidesPerGroup: 1,
            slidesPerView: 3,
            spaceBetween: 20
        }
    }
  })

  controlled.controller.control = controler
  controler.controller.control = controlled

  initIndexSwipers(clientDewiceWidthMin);
  $(window).on('resize', ()=>initIndexSwipers(clientDewiceWidthMin));
  $('.input_wrapper').on('input', formErrorReset);
  $('.feedback_form').on('input', validator);
  $('.feedback_input_submit').on('click', formChecker);
  if(document.querySelector('.history_content')){
    $('.text_center').css('transform', 'translateX(-'+$('.history_content').css('margin-left')+')')
    window.addEventListener('resize', ()=>{
    $('.text_center').css('transform', 'translateX(-'+$('.history_content').css('margin-left')+')')
    })
  }
    if(document.querySelector('.new_page')){
    $('.text_center').css('transform', 'translateX(-'+$('.page_wrapper').css('margin-left')+')')
    window.addEventListener('resize', ()=>{
    $('.text_center').css('transform', 'translateX(-'+$('.page_wrapper').css('margin-left')+')')
    })
  }

  
  $('body').on('change', '.prod_params_cuts_width_select', priceChanger);

  if(document.querySelector('.prod_params_cuts_width_select_wrapper')){
    let copies = document.querySelectorAll('.prod_params_cuts_width_select_wrapper');
    let origins = document.querySelectorAll('.variations .value');
    for(let i =0; i<origins.length; i++){
        copies[i].innerHTML = origins[i].innerHTML;
        copies[i].querySelector('select').classList.add('prod_params_cuts_width_select');
        copies[i].setAttribute('style', `z-index: ${origins.length - i}`)
    }
  }
  $('.prod_params_cuts_width_select_wrapper a').css('display', 'none');
  $('.prod_params_cuts_width_select').attr('onfocus' ,'this.size=6');
  $('.prod_params_cuts_width_select').attr('onblur' ,'this.size=1');
  $('.prod_params_cuts_width_select').attr('onchange' ,'this.size=1; this.blur();');
  if(document.querySelector('.prod_params_cuts')){
    $('#qty').attr('disabled' ,'');
    $('#qty').next().attr('disabled', '');
    $('#qty').prev().attr('disabled', '');
  } 
});

var mini_swiper, mini_swiper2, category_swiper, category_swiper2;


function initIndexSwipers (clientDewiceWidthMin) {
    if(document.querySelector('.index_swiper_mini')){
        if(clientDewiceWidthMin.matches){
            if(mini_swiper2 !== undefined){
                mini_swiper2.destroy(true, true)
                mini_swiper2 = undefined
            }
            if (mini_swiper === undefined){
            mini_swiper = new Swiper('.index_swiper_mini', {
            slidesPerGroup: 1,
            slidesPerView: 1,
            speed: 300,
            spaceBetween: 15,
            })}
        } else {
            if(mini_swiper !== undefined){
            mini_swiper.destroy(true, true)
            mini_swiper = undefined
            }
            if(mini_swiper2 === undefined){
                mini_swiper2 = new Swiper('.index_swiper_mini', {
                    direction: 'vertical',
                    slidesPerGroup: 2,
                    slidesPerView: 2,
                    speed: 300,
                    spaceBetween: 15,
                })
            }
        }
    }
    if (document.querySelector('.categories_wrapper')){
        if (clientDewiceWidthMin.matches){
            if(category_swiper === undefined){
                $('.categories_card').addClass('swiper-slide')
                category_swiper = new Swiper ('.categories_content', {
                    speed: 300,
                    spaceBetween: 15,
                    createElements: true,
                    pagination: false,
                    navigation: false,
                    slidesPerGroup: 1,
                    slidesPerView: 1,
                    slideClass: 'categories_card'
                })
            }
            } else {
                if(category_swiper !== undefined ){
                    category_swiper.destroy(true, true)
                    category_swiper = undefined;
                    $('.categories_card').removeClass('swiper-slide')
                    var slides = Array.from(document.querySelectorAll('.categories_card'));
                    document.querySelector('.categories_content .swiper-wrapper').remove();
                    slides.forEach(el=>document.querySelector('.categories_content').appendChild(el))
                }
        }
    }
    if(document.querySelector('.history_swiper_mini')){
        new Swiper ('.history_swiper_mini', {
            a11y: false,
            speed: 300,
            pagination: false,
            navigation: false,
            slidesPerGroup: 1,
            breakpoints: {
                0: {
                    spaceBetween: 15,
                    slidesPerView: 1,

                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                1200: {
                    spaceBetween: 20,
                    slidesPerView: 2,
                }
            }
        })
    }

    initCompareSwiper();
    
    var singleProdActiveIndex, singleProdSlides, singleProdCurSlide;

    singleProdSwiper = new Swiper('.single_product_swiper', {
        a11y: false,
        speed: 300,
        slidesPerGroup: 1,
        slidesPerView: 1,
        // loop: true,
        navigation: {
            nextEl: '.single_product_swiper_next',
            prevEl: '.single_product_swiper_prev',
        },
        on: {
            init: function () {
                singleProdActiveIndex = this.activeIndex;
                singleProdSlides = this.slides;
                singleProdCurSlide = singleProdSlides[singleProdActiveIndex];
                $('.single_product_swiper_slide_img').attr('src', singleProdCurSlide.querySelector('img').getAttribute('src'));
                $('.single_product_swiper_full_screen_next').on('click', ()=>{
                    if(!this.isEnd){
                        $('.single_product_swiper_slide_img').addClass('img_transparent');
                        this.slideNext();
                        setTimeout(()=>{
                            $('.single_product_swiper_slide_img').removeClass('img_transparent');
                        }, 400);
                        $('.single_product_swiper_full_screen_next').removeClass('swiper-button-disabled')
                    }
                });
                $('.single_product_swiper_full_screen_prev').on('click', ()=>{
                    if(!this.isBeginning){
                        $('.single_product_swiper_slide_img').addClass('img_transparent');
                        this.slidePrev();
                        setTimeout(()=>{
                            $('.single_product_swiper_slide_img').removeClass('img_transparent');
                        }, 400)
                    }
                })
                if(document.querySelector('.single_product_swiper_slide_img')){
                    changeImgSize (document.querySelector('.single_product_swiper_slide_img'))
                }
            },
            slideChange: function () {
                singleProdActiveIndex = this.activeIndex;
                singleProdCurSlide = singleProdSlides[singleProdActiveIndex];
                singleProdChangeSlide(this, singleProdCurSlide.querySelector('img'))
            },
        }
    })
    
    var singleProdSwiperControl = new Swiper('.single_product_swiper_controler', {
        a11y: false,
        speed: 300,
        slidesPerGroup: 1,
        navigation: {
            nextEl: '.single_product_swiper_controller_next',
            prevEl: '.single_product_swiper_controller_prev',
        },
        breakpoints: {
            0: {
                slidesPerView: 2,
                spaceBetween: 15,
            },
            767: {
                slidesPerView: 3,
                spaceBetween: 15,
            },
            1200: {
                slidesPerView: 3,
                spaceBetween: 20,
            }
        }
    })
    
    // var singleProdSwiperOverlay = new Swiper('.single_product_swiper_full_screen', {
    //     a11y: false,
    //     speed: 300,
    //     slidesPerGroup: 1,
    //     slidesPerView: 1,
    //     keyboard: {
    //         enabled: true,
    //     },
    //     navigation: {
    //         nextEl: '.single_product_swiper_next',
    //         prevEl: '.single_product_swiper_prev',
    //     },
    // })
    
    // singleProdSwiperOverlay.controller.control = singleProdSwiper;
    // singleProdSwiper.controller.control = singleProdSwiperOverlay;
    
    // singleProdSwiper.controller.control = singleProdSwiperControl;
    singleProdSwiperControl.on('click', ()=>{
        singleProdSwiper.slideTo(singleProdSwiperControl.clickedIndex, 300)
        singleProdSwiperControl.slideTo(singleProdSwiperControl.clickedIndex, 300)
    })
    singleProdSwiper.on('slideChange', ()=>{
        singleProdSwiperControl.slideTo(singleProdSwiper.activeIndex)
    })
    // singleProdSwiperControl.controller.control = singleProdSwiper;

    if(document.querySelector('.cross_sells_swiper')){
        new Swiper ('.cross_sells_swiper', {
            a11y: false,
            speed: 300,
            pagination: false,
            navigation: false,
            slidesPerGroup: 1,
            watchSlidesProgress: true,
            navigation: {
                nextEl: '.cross_sells_swiper_next',
                prevEl: '.cross_sells_swiper_prev',
            },
            breakpoints: {
                0: {
                    spaceBetween: 15,
                    slidesPerView: 1,

                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 15,
                },
                1200: {
                    spaceBetween: 20,
                    slidesPerView: 4,
                }
            }
        })
    }

    if(document.querySelector('.actions_n_sales_swiper')){
        new Swiper('.actions_n_sales_swiper',{
            a11y: false,
            speed: 300,
            pagination: false,
            navigation: {
                nextEl: '.actions_n_sales_swiper_next',
                prevEl: '.actions_n_sales_swiper_prev',
            },
            breakpoints: {
                0: {
                    spaceBetween: 15,
                    slidesPerView: 1,

                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 15,
                },
                1200: {
                    spaceBetween: 20,
                    slidesPerView: 2,
                }
            }
        })
    }
}

function openMainmenu(e) {
    var m = e.target.closest('.header_menu_item');
    var menuels = document.querySelectorAll('.header_content_inner .header_menu_item')
    menuels.forEach(el=>{
        if (el === m) {
            menuels.forEach(el2 =>{
                if (el2 !== m) {
                    if (el2.querySelector('.sub-menu')) {
                        // $(el2.querySelector('.sub-menu')).slideUp(500);
                        $(el2.querySelector('.sub-menu')).removeClass('header_submenu_shown')

                    }
                }
            }
            )
        }
    })
    // if (m) {
    //     clearTimeout (closeMenuTO)
    //     closeMenuTO = undefined
    // } else {
        // if (closeMenuTO !== undefined) {
        // closeMenuTO = setTimeout(() => {
            // $(m).find('.sub-menu').slideUp();
            $(m).find('.sub-menu').removeClass('header_submenu_shown');
            // clearTimeout(closeMenuTO)
            // closeMenuTO = undefined
        // }, 500);}
    // }
    // $(m).find('.sub-menu').slideDown();
    $(m).find('.sub-menu').addClass('header_submenu_shown');
}

function closeMainmenu (e) {
    var m = e.target.closest('.header_menu_item');
    // closeMenuTO = setTimeout(() => {
        // $(m).find('.sub-menu').slideUp();
        $(m).find('.sub-menu').removeClass('header_submenu_shown');
        //clearTimeout (closeMenuTO)
        //closeMenuTO = undefined
    // }, 500);
}

function openMenuMobile (){
    $('.header_content_inner .header_menu').toggle(300, ()=>{burgerChecker()});
}

function burgerChecker () {
    if($('.header_content_inner .header_menu').css('display') !== 'block'){
        $('#header_menu_cart_item_burger').attr('src', images_oject.open_menu)
    } else {
        $('#header_menu_cart_item_burger').attr('src', images_oject.close_menu)
    }
}

function openSubmenuMobile (e) {
    if($(e.target).attr('href') === '#top'){
        e.preventDefault();
    }
    var el = e.target.closest('.header_menu_item').querySelector('.sub-menu')
    if(el){
    if($(el).css('display') !== 'block') {
        e.preventDefault();
        Array.from(document.querySelectorAll('.header_menu_item>a')).forEach(el=>el.style.setProperty('--rotate-arrow', '0'))
        $('.header_content_inner .sub-menu').slideUp(300)
        $(el).slideDown(300)
        e.target.closest('.header_menu_item').querySelector('.header_menu_item>a').style.setProperty('--rotate-arrow', '180deg')
    }}
}

function menuOnScroll () {
    if (pageYOffset > 160){
        $('.header_wrapper').addClass('scrolling_menu');
    } 
    if (pageYOffset < 10){
        $('.header_wrapper').removeClass('scrolling_menu')
    }
}

function footerChanger (matcher) {
    var events = eventsList($('.footer_menu_wrapper .header_menu_item>a'))
    if (matcher.matches) {
        $('.footer_menu_wrapper .header_menu_item>a').off('click', preventer);
        if(!events){
            $('.footer_menu_wrapper .header_menu_item>a').on('click', footerMenuOpener);
        }
    } else {
        $('.footer_menu_wrapper .header_menu_item>a').off('click', footerMenuOpener);
        if (!events){
            $('.footer_menu_wrapper .header_menu_item>a').on('click', preventer);
        }
        $('.footer_menu_wrapper .sub-menu').removeAttr('style');
        $('.footer_menu_wrapper .header_menu_item>a').removeAttr('style');
        
    }
}

function preventer (e) {
    if($(e.target).attr('href') === '#top'){
        e.preventDefault();
    }
}

function menuChanger (matcher) {
    Array.from(document.querySelectorAll('.header_menu_item')).forEach(el=>{
        if(el.querySelector('.sub-menu')){return} else{
            el.querySelector('a').classList.add('nocontent');
            el.style.paddingRight = '10px';
        }
    })
    if (matcher.matches) {
        var events = eventsList($('#header_menu_cart_item_burger'))
        if (!events.click) {
            $('.header_content_inner .header_menu_item').off('mouseover', openMainmenu);
            $('.header_content_inner .header_menu_item').off('mouseleave', closeMainmenu);
            $('.header_content_inner #header_menu_cart_item_burger').on('click', openMenuMobile);
            $('.header_content_inner .header_menu_item>a').on('click', openSubmenuMobile);
            $(window).off('scroll', menuOnScroll);
            $('.header_content_inner .header_wrapper').removeClass('scrolling_menu');
            $('.header_content_inner .header_menu').css('display', 'none');
            $(window).on('scroll', menuOnScroll);
        }
        $('.header_content_inner .header_menu').css('transform', 'translateX(-'+$('.header_content_inner').css('margin-left')+')');
        $('.header_content_inner .header_menu').css('width', $('body').width()+'px');
        burgerChecker();
    } else {
        var events = eventsList($('.header_menu_item'))
        if (!events.mouseover && !events.mouseleave){
            $('.header_content_inner .header_menu_item').on('mouseover', openMainmenu);
            $('.header_content_inner .header_menu_item').on('mouseleave', closeMainmenu);
            $('.header_content_inner .header_menu').css('transform', 'translateX(0)');
            $('.header_content_inner #header_menu_cart_item_burger').off('click', openMenuMobile)
            $('.header_content_inner .header_menu').css('width', '100%')
            $('.header_content_inner .header_menu').css('display', 'flex')
            $('.header_content_inner .header_menu_item>a').off('click', openSubmenuMobile)
            $(window).on('scroll', menuOnScroll)
            if (pageYOffset > 160){
                $('.header_wrapper').addClass('scrolling_menu');
            } 
        }
        burgerChecker();
    }
}

function eventsList(element) {
    var events = element.data('events');
    if (events !== undefined) return events;

    events = $.data(element, 'events');
    if (events !== undefined) return events;

    events = $._data(element, 'events');
    if (events !== undefined) return events;

    events = $._data(element[0], 'events');
    if (events !== undefined) return events;

    return false;
}

function footerMenuOpener (e){
    if($(e.target).attr('href') === '#top'){
        e.preventDefault();
    }
    var el = e.target.closest('.footer_menu_wrapper .header_menu_item').querySelector('.footer_menu_wrapper .sub-menu')
    if(el){
    if($(el).css('display') !== 'block'){
        Array.from(document.querySelectorAll('.footer_menu_wrapper .header_menu_item>a')).forEach(el=>el.style.setProperty('--rotate-arrow', '0'));
        $('.footer_menu_wrapper .sub-menu').slideUp(300);
        $(el).slideDown(300);
        el.closest('.footer_menu_wrapper .header_menu_item').querySelector('.footer_menu_wrapper .header_menu_item>a').style.setProperty('--rotate-arrow', '180deg')
    }}
}

//Для формы
function formErrorReset (e) {
    if(e.target.closest('.input_wrapper').querySelector('.error')){
        e.target.closest('.input_wrapper').querySelector('.error').remove();
        e.target.classList.remove('input_error')
    }
}

function formChecker (e) {
    e.preventDefault()
    var checks = []
    let exp = /([A-Za-z0-9]+\.*)+@[A-Za-z0-9]+\.[a-z]{2,4}/;
    var mailTest = new RegExp(exp);
    var inputs = Array.from(document.querySelectorAll('.input_wrapper'))
    Array.from(document.querySelectorAll('.feedback_input')).forEach(input=>{
        if(input.value !== ''){
            switch(input.getAttribute('name')){
                case 'name': input.value.length < 4 ? checks.push(false) : checks.push(true); break;
                case 'phone': input.value.length=16 ? checks.push(true) : checks.push(false); break;
                case 'email': mailTest.test(input.value) ? checks.push(true) : checks.push(false); break;
                case 'comment': input.value.length < 5 ? checks.push(false) : checks.push(true); break;
            }
        }else{checks.push(false)}
    })
    for(var i = 0; i<checks.length; i++){
        if(!checks[i]){
            var error = document.createElement('span');
            error.setAttribute('class', 'error');
            var msg = ''
            switch (i){
                case 0: msg = "Слишком короткое имя"; break;
                case 1: msg = "Слишком короткий номер телефона"; break;
                case 2: msg = "Не верный формат почты"; break;
                case 3: msg = "Слишком короткий комментарий"; break;
            }
            error.innerHTML = msg;
            if(!inputs[i].querySelector('.error')){
                inputs[i].appendChild(error);
                inputs[i].querySelector('.feedback_input').classList.add('input_error');
            }
        }
    }
    if(!document.querySelector('.error')){
        var name = $('.feedback_input[name="name"]').val();
        var inputphone = $('.feedback_input[name="phone"]').val();
        var email = $('.feedback_input[name="email"]').val();
        var comment = $("#comment").val();
        transObj={
            action: 'consult_request',
            nonce: images_oject.nonce,
            name: name,
            phone: inputphone,
            email: email,
            comment: comment,
        }
        $.post(images_oject.ajaxurl, transObj, function(data){
            if(data === "ok"){
                $('.cart_cheout_wrapper').addClass('show');
                Array.from(document.querySelectorAll('.feedback_input')).forEach(input=>{
                    input.value = "";
                    document.querySelector('#agree').checked = false;
                })
            }
        });
    }
}

function validator () {
    var checks = []
    Array.from(document.querySelectorAll('.feedback_input')).forEach(check=>{
        check.value.length > 3 ? checks.push(true) : checks.push(false)
    })
    checks.push(document.querySelector('#agree').checked)
    var ok = checks.indexOf(false)
    ok === -1 ? document.querySelector('.feedback_input_submit').removeAttribute('disabled') : document.querySelector('.feedback_input_submit').setAttribute('disabled', '')
}

function starFiller () {
    var rait = 0;
    var id = ''
    var chbxs = Array.from(document.querySelectorAll('.feedback_page_raiting')).forEach(chbx=>{
        if(chbx.checked){
            id = chbx.getAttribute('id');
        }
        })
    switch (id){
        case 'raiting_1': rait = 1; break;
        case 'raiting_2': rait = 2; break;
        case 'raiting_3': rait = 3; break;
        case 'raiting_4': rait = 4; break;
        case 'raiting_5': rait = 5; break;
        default: rait = 0; break;
    }
    rait -= 1;
    if(rait === -1){
        $('.feedback_page_raiting_label').css('background-image', `url(${images_oject.star_empty})`);
        return;
    }
    var  stars = Array.from(document.querySelectorAll('.feedback_page_raiting_label'));
    for (var i = 0; i<stars.length; i++){
        if(rait >= stars.indexOf(stars[i])){
            stars[i].style.backgroundImage = `url(${images_oject.star_filled})`
        } else {
            stars[i].style.backgroundImage = `url(${images_oject.star_empty})`
        }
    }
}

function textAreaValuer () {
    document.querySelector('.feedback_page_form input[name="feedback_page_raiting_textarea_value"]').value = document.querySelector('#feedback_page_raiting_textarea_id').value
    document.querySelector('.feedback_page_raiting_textarea_restrictions').innerHTML = document.querySelector('#feedback_page_raiting_textarea_id').value.length+" из 1000 символов (Минимум 25 символов)"
}

function chekFeedBackForm (e) {
    
    if(document.querySelector('.feedback_page_form_name').value.length < 3){
        e.preventDefault();
        var error = document.createElement('span');
        error.setAttribute('class', 'error');
        var msg = 'Слишком короткое имя'
        error.innerHTML = msg;
        document.querySelector('.feedback_page_form_name').classList.add('input_error');
        if(!document.querySelector('.feedback_page_form_name_wrapper>.error')){
            document.querySelector('.feedback_page_form_name_wrapper').appendChild(error)
        }
    }
    if(document.querySelector('#feedback_page_raiting_textarea_id').value.length < 25 || document.querySelector('#feedback_page_raiting_textarea_id').value.length > 1000) {
        e.preventDefault();
        var error = document.createElement('span');
        error.setAttribute('class', 'error');
        var msg = 'Слишком короткий отзыв';
        error.innerHTML = msg;
        document.querySelector('#feedback_page_raiting_textarea_id').classList.add('input_error');
        if(!document.querySelector('.feedback_page_raiting_textarea_wrapper>.error')){
            document.querySelector('.feedback_page_raiting_textarea_wrapper').appendChild(error)
        }
    }
    if(!document.querySelector('.feedback_page_raiting:checked')){
        e.preventDefault();
        var error = document.createElement('span');
        error.setAttribute('class', 'error');
        var msg = 'Пожалуйста, поставьте оценку';
        error.innerHTML = msg;
        if(!document.querySelector('.feedback_page_rating_wrapper>.error')){
            document.querySelector('.feedback_page_rating_wrapper').appendChild(error)
        }
    }
    if (!grecaptcha.getResponse()) {
        e.preventDefault();
        var error = document.createElement('span');
        error.setAttribute('class', 'error');
        var msg = 'Подтвердите, что Вы не рообот';
        error.innerHTML = msg;
        if(!document.querySelector('.g-recaptcha>.error')){
            document.querySelector('.g-recaptcha').appendChild(error)
        }
   }
    if(!document.querySelector('.feedback_page_form .error')){
        // var transObj = {
        //     secret: document.querySelector('.auth__pass').value,
        //     response: document.querySelector('.auth__pass2').value,
        // }
        // $.post(' https://www.google.com/recaptcha/api/siteverify', transObj, function(data){
        //     data = JSON.parse(data);
        // })
    }
}

function clearErrors (e) {
    var targ = e.target;
    if(targ.classList.contains('input_error')){
        targ.classList.remove('input_error');
        targ.parentElement.querySelector('.error').remove();
    }
    if(targ.getAttribute('class') === 'feedback_page_raiting'){
        if(targ.closest('.feedback_page_rating_wrapper').querySelector('.error')){
            targ.closest('.feedback_page_rating_wrapper').querySelector('.error').remove();
        }
    }
}

function menuMover () {
    var media = matchMedia('(max-width: 1200px)').matches;
    var filter = document.querySelector('.content_filter');
    if(filter){
        if(media){
            filter.remove();
            document.querySelector('.content_wrapper').before(filter);
        } else {
            filter.remove()
            document.querySelector('.main_product_content_wrapper').before(filter);
        }
    }
}

function addToFaforite (e) {
    var tg = $(e.target)
    var id = tg.parents('.data-container').attr('data-prod');
    var fav = $.cookie('favorite');
    var ids
    if (fav){
        ids = fav.split(',');
    } else {
        ids = [];
    }
    if(ids.indexOf(id) != -1 ){
        ids.splice(ids.indexOf(id), 1);
        tg.parents('.data-container').find('.product_sel_heart, .single_product_sel_heart').removeClass('in_favorite');
    } else {
        ids.push(id);
        tg.parents('.data-container').find('.product_sel_heart, .single_product_sel_heart').addClass('in_favorite');
    }
    $.cookie('favorite', ids, {expires: 7, path: '/'});
    if(ids.length > 0) {
        if(document.querySelector('#favorite')){
            document.querySelector('#favorite').innerHTML = ids.length;
        } else {
            var f = document.createElement('span');
            f.setAttribute('class', 'header_count')
            f.setAttribute('id', 'favorite');
            f.innerHTML = ids.length;
            document.querySelector('#favorite_link').appendChild(f);
        }
    } else {
        $('#favorite').remove();
    }
}

function replaceCompareBtn (svgs, calback, calback2, title_text = '') {
    var img = svgs;
    var imgURL = img.attr('src');
    var imgID = img.attr('id');
    var imgClass = img.attr('class');
    var imgOriginClass = img.attr('class');
    $.get(imgURL, function(data) {
        var svg_path = data.querySelector('svg').querySelector('path')
       // Get the SVG tag, ignore the rest
       var svg = jQuery(data).find('svg');

       // Add replaced image's ID to the new SVG
       if(typeof imgID !== 'undefined') {
           svg = svg.attr('id', imgID);
       }
       // Add replaced image's classes to the new SVG
       if(typeof imgClass !== 'undefined') {
           svg = svg.attr('class', imgClass+' replaced-svg');
       }

       // Remove any invalid XML tags as per http://validator.w3.org
       svg = svg.removeAttr('xmlns:a');
        if(title_text != ''){
            var title = document.createElementNS('http://www.w3.org/2000/svg', 'title')
            title.innerHTML = title_text
            svg.append(title)
        }
       // Replace image with new SVG
       img.replaceWith(svg);
       imgOriginClass = '.'+imgOriginClass;
        $(imgOriginClass).on('click', calback);
        calback2();
    }, 'xml');
}

function addToCompare (e) {
    var tg = $(e.target)
    var id = tg.parents('.data-container').attr('data-prod');
    var fav = $.cookie('compare');
    var ids;
    if (fav){
        ids = fav.split(',');
    } else {
        ids = [];
    }
    if(ids.indexOf(id) != -1 ){
        ids.splice(ids.indexOf(id), 1);
        tg.removeClass('in_compare');
    } else {
        ids.push(id);
        tg.addClass('in_compare');
    }
    $.cookie('compare', ids, {expires: 7, path: '/'});
    if(ids.length > 0) {
        if(document.querySelector('#compare')){
            document.querySelector('#compare').innerHTML = ids.length;
        } else {
            var f = document.createElement('span');
            f.setAttribute('class', 'header_count')
            f.setAttribute('id', 'compare');
            f.innerHTML = ids.length;
            document.querySelector('#compare_link').appendChild(f);
        }
    } else {
        $('#compare').remove();
    }
}

function checkIfInCompare () {
    var fav = $.cookie('compare');
    var ids = [];
    if (fav){
        ids = fav.split(',');
    } else {
        ids = [];
    }
    if(ids.length > 0) {
        var prods = document.querySelectorAll('.data-container');
        var prodId = [];
        prods.forEach(prod=>{
            prodId.push(prod.getAttribute('data-prod'));
        })
        ids.forEach(id => {
        var dataContainer = document.querySelector('.data-container[data-prod="'+id+'"]')
            if(dataContainer){
                if(dataContainer.querySelector('.product_btn_compare')){
                    prodId.includes(id) ?  dataContainer.querySelector('.product_btn_compare').classList.add('in_compare') : "";
                }
            }
        })
    }
}

function checkIfInFavorite () {
    var fav = $.cookie('favorite');
    var ids
    if (fav){
        ids = fav.split(',');
    } else {
        ids = [];
    }
    if(ids.length > 0) {
        var prods = document.querySelectorAll('.data-container');
        var prodId = [];
        prods.forEach(prod=>{
            prodId.push(prod.getAttribute('data-prod'));
        })
        ids.forEach(id => {
            var dataContainer = document.querySelector('.data-container[data-prod="'+id+'"]')
            if(dataContainer){
                if(dataContainer.querySelector('.single_product_sel_heart')){
                    prodId.includes(id) ?  dataContainer.querySelector('.single_product_sel_heart').classList.add('in_favorite') : "";
                }   
                if(dataContainer.querySelector('.product_sel_heart')){
                    prodId.includes(id) ?  dataContainer.querySelector('.product_sel_heart').classList.add('in_favorite') : "";
                }
            }
        })
    }
}

function changeImageFavoriteOnSingleProd () {

}


function changeComparision (e){
    var transObj = {
        action: 'change_compare',
        nonce: images_oject.nonce,
        id: e.target.closest('.select_btn').getAttribute('id'),
    }
    $.post(images_oject.ajaxurl, transObj, function(data){
        document.querySelector('.compare_slider_wrapper').innerHTML = data;
        $('.select_btn').on('click', changeComparision)
        $('.select_btn_wrapper img').on('click', deleteComparision);
        replaceCompareBtn($('.product_btn_compare'), addToCompare, checkIfInCompare);
        replaceCompareBtn($('.product_sel_heart'), addToFaforite, checkIfInFavorite);
        initCompareSwiper();
    });
} 

function deleteComparision (e){
    var transObj = {
        action: 'change_compare',
        nonce: images_oject.nonce,
    }
    var objToDel = {
        action: 'delete_compare',
        nonce: images_oject.nonce,
        id: e.target.closest('.select_btn_wrapper').querySelector('.select_btn').getAttribute('id'),
    }
    $.post(images_oject.ajaxurl, objToDel, function(data){
        data = JSON.parse(data);
        var cookies = $.cookie('compare').split(',');
        data.forEach(d => {
            d = d.toString();
            if(cookies.indexOf(d) !== -1){
                if(cookies.length === 1){
                    cookies = []
                } else {
                    cookies.splice(cookies.indexOf(d), 1);
                }
            }
        })
        $.cookie('compare', cookies, {expires: 7, path: '/'});
        if(cookies.length > 0) {
            if(document.querySelector('#compare')){
                document.querySelector('#compare').innerHTML = cookies.length;
            } else {
                var f = document.createElement('span');
                f.setAttribute('class', 'header_count')
                f.setAttribute('id', 'compare');
                f.innerHTML = cookies.length;
                document.querySelector('#compare_link').appendChild(f);
            }
        } else {
            $('#compare').remove();
        }
        $.post(images_oject.ajaxurl, transObj, function(data){
            document.querySelector('.compare_slider_wrapper').innerHTML = data;
            $('.select_btn').on('click', changeComparision);
            $('.select_btn_wrapper img').on('click', deleteComparision);
            initCompareSwiper();
        });
    });
} 

function initCompareSwiper () {
    var product_card_swiper = new Swiper('.product_card_wrapper', {
        speed: 300,
        watchSlidesProgress: true,
        navigation: {
            nextEl: '.phg_swiper_next',
            prevEl: '.phg_swiper_prev',
        },
        breakpoints: {
            0:{
                slidesPerView: 1,
                slidesPerGroup: 1,
                spaceBetween: 15
            },
            767:{
                slidesPerView: 3,
                slidesPerGroup: 1,
                spaceBetween: 15
            },
            1200:{
                slidesPerView: 4,
                slidesPerGroup: 1,
                spaceBetween: 20
            }
        },
        on: {
            transitionStart: compare_swiper_transition,
            sliderMove: compare_swiper_transition,
            touchEnd: compare_swiper_transition
        }
    });
    var compare_prod_attr_swiper = new Swiper('.compare_prod_attr_swiper', {
        speed: 300,
        breakpoints: {
            0:{
                slidesPerView: 1,
                slidesPerGroup: 1,
                spaceBetween: 15
            },
            767:{
                slidesPerView: 3,
                slidesPerGroup: 1,
                spaceBetween: 15
            },
            1200:{
                slidesPerView: 4,
                slidesPerGroup: 1,
                spaceBetween: 20
            }
        },
        on: {
            transitionStart: compare_swiper_transition,
            sliderMove: compare_swiper_transition,
            touchEnd: compare_swiper_transition
        }
    });
    product_card_swiper.controller.control = compare_prod_attr_swiper;
    if(compare_prod_attr_swiper.length){
        if(compare_prod_attr_swiper.length>1){
            compare_prod_attr_swiper.forEach(sw=> sw.controller.control = product_card_swiper);
        }
    } else {
        compare_prod_attr_swiper.controller.control = product_card_swiper;
    }
}

function compare_swiper_transition () {
    var transition = document.querySelector('.compare_prod_attr_swiper .swiper-wrapper').style.transitionDuration
    var transf = document.querySelector('.compare_prod_attr_swiper .swiper-wrapper').style.transform;
    transf = transf.split(',');
    var ind = transf[0].lastIndexOf('(');
    transf = transf[0].substring(ind+1);
    transf = parseFloat(transf);
    transf = Math.abs(transf);
    $('.compare_prod_attr_name').css('transition-duration', transition)
    $('.compare_prod_attr_name').css('transform', 'translate3d('+transf+'px, 0px, 0px)')
}

function calcSubTotal () {
    var qty = $('#qty').val();
    var price = $('#prod_price').html();
    var sell_price = $('#prod_price_sale').html();
    var prod_price = sell_price ? sell_price : price;
    if(prod_price != undefined){
        var price = parseFloat(prod_price.replaceAll(' ', '').replaceAll(',','.'));
        $('.subtotal').html((qty * price).toLocaleString()+' &#8381;');
    }
    if(document.querySelector('.woocommerce-variation-add-to-cart')){
        $('.woocommerce-variation-add-to-cart input[name="quantity"]').val(qty);
    }
    if(document.querySelector('.packages_counter_input')){
        var packages = Math.ceil(qty / $('.packages_counter_input').attr('data-step'));
        packages = packages > 0 ? packages : '' ;
        $('.packages_counter_input').val(packages);
    }
    priceNormalizer();
    buttonController();
}

function calcSubTotalThroughtPackages (){
    var qty = $('.packages_counter_input').val() * $('.packages_counter_input').attr('data-step');
    qty = qty >0 ? qty.toFixed(2) : '';
    $('#qty').val(qty);
    $('#qty').trigger('input')
}

function calcSubTotalThroughtPackagesLinol () {
    var qty = $('.packages_counter_input_linol').val() * $('.packages_counter_input_linol').attr('data-step');
    qty = qty >0 ? qty.toFixed(2) : '';
    $('#qty').val(qty);
    $('#qty').trigger('input')
}

function cutToFitChanger () {
    var val = $('.prod_params_cuts_radio:checked').val();
    if(val == 'full') {
        $('#qty').attr('disabled', '');
        $('#qty').next().attr('disabled', '');
        $('#qty').prev().attr('disabled', '');
        // $('.prod_params_cuts_width_select option[value=""]').prop('selected', true);
        // document.querySelectorAll('.prod_params_cuts_width_select').forEach(sel=>{
        //     sel.querySelector('option[value=""]').selected = true;
        //     $(sel).trigger('change');
        // })

        priceNormalizer();
    }
    if (val == 'cut'){
        $('#qty').removeAttr('disabled');
        $('#qty').next().removeAttr('disabled', '');
        $('#qty').prev().removeAttr('disabled', '');
    }
    calcQtyLin();
    buttonController();
}

function cartMetersCalc() {
    $('body').on('input', '.cart_squares', (e)=>{
        var maxMeters = e.target.getAttribute('data-maxmeters');
        var quantity = parseFloat(e.target.value) * parseFloat(maxMeters);
        var input = e.target.closest('.product-quantity').querySelector('.cart_qty_wrapper input');
        input.value = quantity;
        $(input).change();
    })

    $('body').on('input', '.cart_prods_to_calc', (e)=>{
        var maxMeters = e.target.getAttribute('data-maxmeters');
        var quantity = parseFloat(e.target.value) / parseFloat(maxMeters);
        var input = e.target.closest('.product-quantity').querySelector('.cart_qty_wrapper input');
        input.value = quantity;
        $(input).change();
    })
}

function submitOffer (e) {
    e.preventDefault()

    var namefield = $('#cart_offer_form_name')
    var phonefield = $('#cart_offer_form_phone')
    var emailfield = $('#cart_offer_form_email')

    var name = namefield.val()
    var phone = phonefield.val()
    var email = emailfield.val()
    var shipping = $('[name=cart_offer_form_shipping]:checked').val()
    var adress = $('#cart_offer_form_shipping_adress').val()
    var payment = $('[name=cart_offer_form_payment]:checked').val()
    var comment = $('#cart_offer_form_comment').val()

    var fields = [namefield, phonefield, emailfield]
    var checks = []

    let exp = /([A-Za-z0-9]+\.*)+@[A-Za-z0-9]+\.[a-z]{2,4}/;
    var mailTest = new RegExp(exp);

    name.length < 3 ? checks.push(false) : checks.push(true);
    phone.length < 16 ? checks.push(false) : checks.push(true);
    mailTest.exec(email) ? checks.push(true) : checks.push(false);
    
    var no_errors = true
    var msg = '';
    for(var i = 0; i<checks.length; i++){
        if(!checks[i]){
            switch (i){
                case 0: msg = "Слишком короткое имя"; break;
                case 1: msg = "Слишком короткий номер"; break;
                case 2: msg = "Не верный формат почты"; break;
            }
            var error = document.createElement('span');
            error.setAttribute('class', 'error');
            error.innerHTML = msg
            if(fields[i].next().length == 0) {
                fields[i].after(error)
            }
            no_errors = false
        }
    }

    if(no_errors){
        var transObj = {
            action: "make_offer",
            nonce: images_oject.nonce,
            name: name,
            phone: phone,
            email: email,
            shipping: shipping,
            adress: adress,
            payment: payment,
            comment: comment
        }
        $.post(images_oject.ajaxurl, transObj, function(data){
            if(data == 'ok'){
                if(!$('.cart_cheout_wrapper').hasClass('show')){
                $('.cart_cheout_wrapper').addClass('show')
                }
                if($('.cart_offer_form_wrapper').hasClass('show')){
                    $('.cart_offer_form_wrapper').removeClass('show')
                }
            }
        })
    }
}

function removeErrors (e) {
    if($(e.target).next().length !== 0){
        $(e.target).next().remove()
    }
}

function checkPhoneinput (e) {
    if(e.target.value < 3) {
        e.target.value = "+7(";
    }
    if($(e.target).next().length !== 0){
        $(e.target).next().remove()
    }
}

function changeTableContentWidth () {
        
    var trs = Array.from(document.querySelectorAll('[colspan]'))
    if(!clientDewiceWidth.matches){
        trs.forEach(el=>{
            if(el.getAttribute('colspan') == '1' || el.getAttribute('colspan') == '2'){
                el.setAttribute('colspan', "2")
            }
        })
    } else {
        trs.forEach(el=>{
        if(el.getAttribute('colspan') == '1' || el.getAttribute('colspan') == '2'){
                el.removeAttribute('colspan')
            }
        })
    }
    if(clientDewiceWidthMin.matches){

    }
}

function showSearch () {
    $('.header_menu_cart_search_wrapper .is-search-form').toggle(0);
}

function openSingleProdGalery () {
    $('.single_product_swiper_full_screen_wrapper').addClass('shown')
}

function closeSingleProdGalery () {
    $('.single_product_swiper_full_screen_wrapper').removeClass('shown')
}

 function get_dimensions(el) {
    // Браузер с поддержкой naturalWidth/naturalHeight
    if (el.naturalWidth!=undefined) {
        return { 'real_width':el.naturalWidth,
                 'real_height':el.naturalHeight,
                 'client_width':el.width,
                 'client_height':el.height };
    }
    // Устаревший браузер
    else if (el.tagName.toLowerCase()=='img') {
        var img=new Image();
        img.src=el.src;
        var real_w=img.width;
        var real_h=img.height;
        return { 'real_width':real_w,
                 'real_height':real_h,
                 'client_width':el.width,
                 'client_height':el.height };
    }
    // Что-то непонятное
    else {
        return false;
    }
}

function changeImgSize (el) {
    var dimentions = get_dimensions(el);
    var el_width = dimentions.real_width === 0 ? dimentions.client_width : dimentions.real_width;
    var el_height = dimentions.real_height === 0 ? dimentions.client_height : dimentions.real_height;
    var el_rels = el_width/el_height;
    var max_w = document.querySelector('body').clientWidth * 0.8;
    var max_h = window.innerHeight * 0.8;
    var el_pos_width = max_w;
    var el_pos_height = el_pos_width / el_rels;
    if(el_pos_height > max_h) {
        $('.single_product_swiper_slide_img').css('height', max_h+'px');
        $('.single_product_swiper_slide_img').css('width', 'auto');
    } else {
        $('.single_product_swiper_slide_img').css('width', max_w+'px');
        $('.single_product_swiper_slide_img').css('height', 'auto');
    }
}

function scroll(e) {
    var endTouchX = event.changedTouches[0].clientX;
    var endTouchY = event.changedTouches[0].clientY;
    var deltaXMod = Math.abs(startTouchX -endTouchX);
    var deltaYMod = Math.abs(startTouchY - endTouchY);
    if (deltaYMod < deltaXMod ) {
        deltaY = startTouchX - endTouchX;
    } else (deltaY = 0);
}

function singleProdChangeSlide (slider, img){
    setTimeout(()=>{
        $('.single_product_swiper_slide_img').attr('src', img.getAttribute('src'));
        if(document.querySelector('.single_product_swiper_slide_img')){
            changeImgSize (img);
        }
    }, 200);
    if(slider.isEnd){
        $('.single_product_swiper_full_screen_next').addClass("disabled")
    } else {
        $('.single_product_swiper_full_screen_next').removeClass('disabled')
    }
    if(slider.isBeginning){
        $('.single_product_swiper_full_screen_prev').addClass('disabled')
    } else {
        $('.single_product_swiper_full_screen_prev').removeClass('disabled')
    }
}

function sliderKeyPressListener (e) {
    if ($('.single_product_swiper_full_screen_wrapper').hasClass('shown')){
        if(e.keyCode === 39){
            if(!singleProdSwiper.isEnd){
                $('.single_product_swiper_slide_img').addClass('img_transparent');
                singleProdSwiper.slideNext();
                setTimeout(()=>{
                    $('.single_product_swiper_slide_img').removeClass('img_transparent');
                }, 400);
                $('.single_product_swiper_full_screen_next').removeClass('swiper-button-disabled')
            }
        }
        if(e.keyCode === 37){
            if(!singleProdSwiper.isBeginning){
                $('.single_product_swiper_slide_img').addClass('img_transparent');
                singleProdSwiper.slidePrev();
                setTimeout(()=>{
                    $('.single_product_swiper_slide_img').removeClass('img_transparent');
                }, 400)
            }
        }
        if(e.keyCode === 27) {
            closeSingleProdGalery();
        }
    }
}

function priceChanger (e) {
    var tv = '';
    if(e){
        tv = e.target.value;
    }
    $(`.variations [name="${e.target.getAttribute('name')}"]`).val(tv);
    $(`.variations [name="${e.target.getAttribute('name')}"]`).trigger('change');
    if($('.prod_params_cuts_width_select').length > 1) {
        document.querySelectorAll('.prod_params_cuts_width_select').forEach(el=>{
            document.querySelectorAll('.variations select').forEach(elinn=>{
                if(el.getAttribute('name') === elinn.getAttribute('name')){
                    if(e.target.getAttribute('name') != el.getAttribute('name')){
                        el.innerHTML = elinn.innerHTML;
                        $(el).val($(elinn).val());
                    }
                }
            })
        })
    }
    let price = 0;
    let salePrice = 0;
    var params = JSON.parse($('.variations_form').attr('data-product_variations'))
    let sels = {};
    document.querySelectorAll('.prod_params_cuts_width_select').forEach(sel=>{
        let attr_name = sel.getAttribute('data-attribute_name')
            sels[`${attr_name}`] = sel.value;
    });
    params.forEach(param=>{
        if(JSON.stringify(param.attributes) === JSON.stringify(sels) ){
            $('.stok_wrapper').html(param.pred_request);
            if(document.querySelector('.woocommerce-variation-price del')){
                price = parseFloat($('.woocommerce-variation-price del bdi').text().replaceAll(",", "."), 2);
            } else {
                price = parseFloat($('.woocommerce-variation-price .amount bdi').text().replaceAll(",", "."), 2);
            }
            if(price){ $('#prod_price').text(price.toLocaleString());}
            if(document.querySelector('.woocommerce-variation-price ins')){
                salePrice = parseFloat($('.woocommerce-variation-price ins bdi').text().replaceAll(",", "."));
            }
            if(salePrice >0) {
                if(!document.querySelector('#prod_price_sale')){
                    var spanVr = document.createElement('span');
                    spanVr.setAttribute('class', 'single_prod_sale_price');
                    if($('#prod_price').attr('data-d') === 'd'){
                        spanVr.innerHTML = `От <span id="prod_price_sale" data-d="d">${salePrice}</span> ₽ / м2`;
                    } else {
                        spanVr.innerHTML = `От <span id="prod_price_sale" data-d="nd">${salePrice}</span> ₽`;
                    }
                    $('.single_prod_price').before(spanVr)
                    $('.single_prod_price').addClass('single_prod_price_saled');
                } else {
                    $('#prod_price_sale').text(salePrice.toLocaleString());
                }
            } else {
                $('.single_prod_sale_price').remove();
                $('#prod_price_sale').text('');
                $('.single_prod_price').removeClass('single_prod_price_saled');
            }
        }
    })
    calcQtyLin();
    let w = parseFloat($('[data-nam]').find('select').val().replaceAll(',','.'));
    let l = parseFloat($('[data-nam]').attr('data-nam').replaceAll(',','.'));
    let s = w * l
    $('#packages_counter_input_linol').attr("data-step", s)
    let r = parseFloat ($("#packages_counter_input_linol").val());
    $('#qty').val(s * r)
}

function calcQtyLin (){
    if($('#qty').attr('disabled') != undefined && $("#prod_params_nocut")[0].checked){
        if($('[data-nam]').attr('data-nam') !== ''){
            let a = true;
            document.querySelectorAll(".prod_params_cuts_width_select").forEach(el=>{
                if($(el).val() == ''){a = false}
            })
            if(!a){$('#qty').val(""); return a}
            let w = parseFloat($('[data-nam]').find('select').val().replaceAll(',','.'));
            let l = parseFloat($('[data-nam]').attr('data-nam').replaceAll(',','.'));
            let s = w * l
            let r = parseFloat ($("#packages_counter_input_linol").val());
            r > 0 ? r : 1;
            $('#qty').val(s * r)
        }
    }
}

function priceNormalizer() {
    if(document.querySelector('.variations_form') && $('.prod_params_cuts_width_select').val() == ''){
        let p = [];
        let l = [];
        let attrs = JSON.parse($('.variations_form').attr('data-product_variations'));
        attrs.forEach(element => {
            p.push(element.display_regular_price);
        });
        attrs.forEach(element => {
            l.push(element.display_price);
        }); 
        let minp = Math.min.apply(null, p);
        $('#prod_price').text(minp);
        $('.single_prod_sale_price').remove();
        $('.single_prod_price ').removeClass('single_prod_price_saled');
        $('.stok_wrapper').html(startStockStatus);
    }
}
buttonController();

function buttonController() {
    if ($('.prod_params_cuts_width_select').val()=='' && !$('.prod_params_cuts_width_select').val()==undefined){
        $('.single_add_to_cart_button_vis').addClass('disabled')
        return false;
    }
    if ($('.single_add_to_cart_button ').hasClass('disabled')){
        $('.single_add_to_cart_button_vis').addClass('disabled')
    } else {
        $('.single_add_to_cart_button_vis').removeClass('disabled')
    }
}