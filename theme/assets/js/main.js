(function($){



var img_path = tmp_path.url;
var body = document.body;


function getBackgroundImageByCSS(fileRegExp, selectorRegExp) {
    var results = [];
    var sheets = document.styleSheets;
    for(var i = 0; i < sheets.length; i++) {
        if(String(sheets[i].href).match(fileRegExp)){
            var rules = sheets[i].cssRules;
            for(var j = 0; j < rules.length; j++) {
                var url = rules[j].style['background-image'].match(/^url\("(.+?)"\)$/);
                if(rules[j].selectorText.match(selectorRegExp) && url) {
                    results.push(url[1])
                }
            }
        }
    }
    return results;
}


var detectMedia = function() {
  var callback = function() {
    var w = window.innerWidth;
    if ( w < 681 ) {
      body.classList.add('is-sp');
      body.classList.remove('is-pc');
    } else {
      body.classList.add('is-pc');
      body.classList.remove('is-sp');
    }
  };

  window.addEventListener('load', callback);
  window.addEventListener('resize', callback);
};


var pagenavClass = function() {
  var pgnvItem = document.querySelectorAll('.pgnv a');
  for (var i = pgnvItem.length - 1; i >= 0; i--) {
    var el = pgnvItem[i];
    if ( el.classList.contains('next') || el.classList.contains('prev') ) {
      el.classList.add('page-numbers_np');
    }
  }
}


var sideNavHover = function() { // サイドナビホバーアニメーション
  var sdieNavDots = document.querySelectorAll('.sideNav li a');
  for (var i = sdieNavDots.length - 1; i >= 0; i--) {
    var el = sdieNavDots[i];
    el.onmouseover = function() {
      // this.parentNode.style.overflow = 'visible';
      // this.nextElementSibling.style.top = 0;
      // this.nextElementSibling.style.opacity = 1;
    }
    el.onmouseout = function() {
      var el = this;
      // this.nextElementSibling.style.top = '-'+14+'px';
      // this.nextElementSibling.style.opacity = 0;
      // setTimeout(function(){
      //   el.parentNode.style.overflow = 'hidden';
      // }, 80);
    }
  }
};


/*
 * ここからTOPページアニメーション
 **/
var topPageAnim = function() { // TOPページアニメーションまとめ

  var topAnimBtn = document.querySelectorAll('.navInner li a'),
      headerLogo = document.querySelector('.siteHeader .logo'),
      sideNav = document.querySelector('.sideNav'),
      sideNav1st = document.querySelector('.sideNav li:first-child'),
      sideNavLast = document.querySelector('.sideNav li:last-child'),
      siteHeader = document.querySelector('.siteHeader'),
      btnGnav = document.querySelector('.btnGnav'),
      firstTtl = document.querySelector('#view100Block1 .ttl1'),
      contactBnr = document.querySelector('.wrap_bnrBox.contact'),
      sepCont = document.querySelectorAll('.sepCont'),
      footer = document.querySelector('.siteFooter'),
      block1 = document.getElementById('view100Block1'),
      block2 = document.getElementById('view100Block2'),
      block3 = document.getElementById('view100Block3'),
      block4 = document.getElementById('view100Block4'),
      block5 = document.getElementById('view100Block5'),
      block6 = document.getElementById('view100Block6'),
      block7 = document.getElementById('view100Block7'),
      blockC_box1 = document.querySelector('.blockCBox1'),
      blockC_box2 = document.querySelector('.blockCBox2'),
      blockC_box3 = document.querySelector('.blockCBox3'),
      blockC_box4 = document.querySelector('.blockCBox4'),

      cv = '',
      cvEl = '',
      cvId = '',
      nextBlockEl = '',
      nextBlock = '',
      cNav = '',
      isLast = '',

      cvTtl = '',
      cvBlockMain = '',
      cvBtnMore1 = '',
      cvBlockMainImg = '',
      nextTtl = '',
      nextBlockMain = '',
      nextBtnMore1 = '',
      nextBlockMainImg = '',

      scrollCount = 0;

  // 1枚目を表示
  // block1.style.opacity = 1;

  var ajustLine = function() { // レイヤーを分割
    var ww = window.innerWidth;

    for (var i = sepCont.length - 1; i >= 0; i--) {
      var el = sepCont[i];
      var child = el.children;

      for (var ii = child.length - 1; ii >= 0; ii--) {
        var _el = child[ii];
        var _child = _el.children;
        var cW = ww / 5;
        var elW = cW * ii;

        _child[0].style.width = ww + 'px';
        _child[0].style.marginLeft = '-' + elW + 'px';
      }
    }
  };
  window.addEventListener('load', ajustLine);
  window.addEventListener('resize', ajustLine);


  var sideNavBtnReset = function() {
    for (var i = topAnimBtn.length - 1; i >= 0; i--) {
      topAnimBtn[i].parentNode.classList.remove('on'); // サイドナビボタンのカレント削除
    }
  };


/*
 * ページ遷移
 **/
  for (var i = topAnimBtn.length - 1; i >= 0; i--) {
    var el = topAnimBtn[i]; // サイドナビボタン

/*
 * サイドナビボタンをクリックした時の処理
 **/
    el.onclick = function() {
      cv = document.querySelector('.currentView');
      cvEl = document.querySelector('.currentView');
      cvId = '#' + cv; // 現在表示されてるページID
      nextBlock = this.dataset.block;
      nextBlockId = '#' + this.dataset.block;
      nextBlockEl = document.querySelector(nextBlockId);
      var wB = window.pageYOffset + innerHeight; // ウィンドウ最下部座標


      cvTtl = document.querySelector('.currentView .ttl1');
      cvBlockMain = document.querySelector('.currentView .blockMain');
      cvBtnMore1 = document.querySelector('.currentView .txtBlock .btnMore1');
      cvBlockMainImg = document.querySelector('.currentView .blockMainImg');
      nextTtl = document.querySelector(nextBlockId + ' .ttl1');
      nextBlockMain = document.querySelector(nextBlockId + ' .blockMain');
      nextBtnMore1 = document.querySelector(nextBlockId + ' .txtBlock .btnMore1');
      nextBlockMainImg = document.querySelector(nextBlockId + ' .blockMainImg');

      cNav = document.querySelector('.sideNav li on');
      nextNav = this.parentNode;

      isLast = false;
      scrollCount = 0;

      if ( nextBlock ) { // 遷移先があれば
        // sideNavBtnReset();
        // nextNav.classList.add('on'); // サイドナビボタンのカレント追加

        // bodyClass();
      } else { // contactボタン押した時
        // bnrInOut();
      }
    }; // end onclick
  } // end for topAnimBtn

/*
 * スクロールした時の処理
 **/
  var c = 0,
      s = 0,
      sc = '',
      mousewheelevent = 'onwheel' in document ? 'wheel' : 'onmousewheel' in document ? 'mousewheel' : 'DOMMouseScroll';

  try {
    document.addEventListener (mousewheelevent, onWheel, false);
  } catch(e) {
    //for legacy IE
    // document.attachEvent ("onmousewheel",);
  }
//





/*
 * SP
 **/

  function Position(e){ // 現在位置を得る
    var x   = e.originalEvent.touches[0].pageX;
    var y   = e.originalEvent.touches[0].pageY;
    x = Math.floor(x);
    y = Math.floor(y);
    var pos = {'x':x , 'y':y};
    return pos;
  }
}; // end topPageAnim


var gNavAnim = function() {
  var gNav = document.querySelector('.gNav'),
      gNavIn = document.querySelector('.gNav > nav > ul'),
      gNavItem = document.querySelectorAll('.gNav > nav > ul > li');

  var load = function() {
    for (var i = gNavItem.length - 1; i >= 0; i--) {
      var el = gNavItem[i];
      if ( body.classList.contains('is-pc') ) {
        el.style.marginLeft = '-' + 70 * i + 'px';
      } else {
        el.style.marginLeft = '-' + 30 * i + 'px';
      }
    }
  }

  var scroll = function() {
    var sT = gNav.scrollTop;

    for (var i = gNavItem.length - 1; i >= 0; i--) {
      var el = gNavItem[i];
      if ( body.classList.contains('is-pc') ) {
        el.style.marginRight = '-' + ( sT/4 ) + 'px';
      } else {
        el.style.marginRight = '-' + (sT/2.5) + 'px';
      }
    }
  }
  window.addEventListener('load', load);
  gNav.addEventListener('scroll', scroll);
};



var pageWrap = document.getElementById( 'pagewrap' ),
    pages = [].slice.call( pageWrap.querySelectorAll( '.loader' ) ),
    currentPage = 0,
    triggerLoading = [].slice.call( pageWrap.querySelectorAll( '.btnLoader' ) ),
    loader = new SVGLoader( document.getElementById( 'loader' ), { speedIn : 700, easingIn : mina.easeinout } ),
    gNav = document.querySelector('.gNav'),
    gNavIn = document.querySelector('.gNav > nav > ul'),
    gNavItem = document.querySelectorAll('.gNav > nav > ul > li');

function pageLoaderInit() {
  triggerLoading.forEach( function( trigger ) {
    trigger.addEventListener( 'click', function( ev ) {
      var _this = this;

      ev.preventDefault();
      loader.show();
      // after some time hide loader

      if ( !_this.classList.contains('btnGnav') ) {
        return false;
      }
      setTimeout( function() {
        loader.hide();

        classie.removeClass( pages[ currentPage ], 'show' );
        // update..
        currentPage = currentPage ? 0 : 1;
        classie.addClass( pages[ currentPage ], 'show' );

        var gNavItem = document.querySelectorAll('.gNav > nav > ul > li > a');

        for (var i = gNavItem.length - 1; i >= 0; i--) {
          var el = gNavItem[i];

          (function(el){
            setTimeout(function(){
              el.classList.add('on');
            }, 200 * i);
          }(el));
        }

        // document.querySelector('.gNav').scrollTo(0, 0);

        if ( body.classList.contains('on-gNav') ) {
          body.classList.remove('on-gNav');
          _this.children[0].src = img_path + '/_assets/images/btn_gNav.png';
          _this.href = '#page-2';
        } else {
          body.classList.add('on-gNav');
          _this.children[0].src = img_path + '/_assets/images/btn_gNav_cls.png';
          _this.href = '#page-1';
        }

      }, 800 );
    } );
  } );
}


var flxbtwn = function() {
  var emp = '',
      gW = document.querySelectorAll('[class*="flx-w-"]');
  for (var i = -1; ++i < 3;) {
    emp += '<li style=" height:0!important;padding:0!important;margin:0!important;visibility:hidden!important;" class="empty-flx"></li>';
  }
  for (var i = gW.length - 1; i >= 0; i--) {
    if ( gW[i].children.length > 1 ) {
      gW[i].innerHTML += emp;
    }
  }
};


var smoothScroll = function() { // スムーズスクロール
  $('a[href^="#"]').click(function() {
    var speed = 600;
    var href= $(this).attr("href");
    var target = $(href == "#" || href == "" ? 'html' : href);
    var position = target.offset().top - 150;
    if ( $('body').hasClass('is-sp') ) {
      var position = target.offset().top - 70;
    }

    $('body,html').delay(200).animate({scrollTop:position}, speed, 'swing');
      return false;
  });
}


var isotope = function() {
  $('.grid').isotope({
    itemSelector: '.grid-item',
    percentPosition: true,
    masonry: {
      columnWidth: '.grid-sizer'
    }
  })
};


var fancyBox = function() {
  $(".fancybox").fancybox({
    prevEffect : 'fade',
    nextEffect : 'fade',
  });
};


var loading = function() {
  body.classList.add('loaded');
};
window.addEventListener('load', loading);


var scrollFunc = function() {
  var scBox = document.querySelectorAll('.sc-box');
  if ( scBox ) {
    var time;

    var callback = function() {
      if ( time ) return;

      time = setTimeout( function() {
        time = 0;

        var wB = window.pageYOffset + innerHeight; // ウィンドウ最下部座標
        var wy = window.pageYOffset + 300; // スクロール量

        for ( var i = scBox.length - 1; i >= 0; i-- ) {
          var el = scBox[i];
          var scBoxTop = wy + el.getBoundingClientRect().top;

          if ( wB > scBoxTop ) {
            if ( !el.classList.contains('on') ) {
              el.classList.add('on');
            }
          }
        }
      }, time);
    };

    window.addEventListener('scroll', callback);
    window.addEventListener('load', callback);
  }
};


var jpostal = function() {
  $('#mw_wp_form_mw-wp-form-37 form').addClass('h-adr');
  if ( $('#mw_wp_form_mw-wp-form-37 .error').length ) {
    $('#mw_wp_form_mw-wp-form-37').addClass('formError');
  }

  $('#btn_post-s').click(function(){
    var u = 'https://www.google.com/search?q=%E9%83%B5%E4%BE%BF%E7%95%AA%E5%8F%B7+';
    var val = $(this).prev().val();
    $(this).removeAttr('href');
    window.open( u + val, "_blank" );
  });
};



var gNavPd = function() {
  $('.gNav .childNav').hide();
  $('.gNav .menu-concept > a').click(function(){
    $('.gNav .childNav').slideToggle();
  });
}


function pageTop() {
  $('.pageTop').click(function(){
    $('body,html').animate({
        scrollTop: 0
      },500);
    return false;
  });
}

function fadeIn_pageTopBtn() {
  if ( $(this).scrollTop()>500 ){
    $('.pageTop').fadeIn();
  } else {
    $('.pageTop').fadeOut();
  }
}


// Androidのバージョン判断
function and_ver() {
  var and_ua = navigator.userAgent;

  if ( and_ua.indexOf("Android") > 0 ) {
    var version = parseFloat(and_ua.slice(and_ua.indexOf("Android")+8));
    body.classList.add('android')
  }
}



function formError() {
  if ( $('.error')[0] ) {
    var target = $('.error');
    var position = target.offset().top -90;
    var speed = 600;
    $('body,html').delay(200).animate({scrollTop:position}, speed, 'swing');
    return false;
  }
}


// fadein anime
function fadeinAnime() {
  var scroll = $(window).scrollTop();
  var windowHeight = $(window).innerHeight();
  var windowBottom = scroll + windowHeight;
  $('.js-fadein').each(function(){
    var fadeinPos = $(this).offset().top - 1;
    if ( fadeinPos < windowBottom ) {
      $(this).addClass('js-fadein-anime');
    }
  });
}

$(window).on('load scroll', function(){
  fadeinAnime();
}); // load resize

function mySwiper() {
  var mySwiper = new Swiper ('.swiper-container', {
    pagination: '.swiper-pagination',
  	loop: true,
    slidesPerView: 1,
		autoplayDisableOnInteraction: false,
    speed: 2000,
    autoplay: 4000,
    effect: 'fade',
    paginationClickable: true
  });
}




// sideNavigation();
fadeinAnime();
and_ver();
pageTop();
detectMedia();
pagenavClass();
if ( body.classList.contains('home') ) {
  sideNavHover();
  topPageAnim(); // TOPページアニメーションまとめ
}
if ( body.classList.contains('single-concept') ) {
  isotope();
  fancyBox();
  window.addEventListener('load', isotope);
}
if ( body.classList.contains('page-contact') ) {
  formError();
}
gNavAnim();
pageLoaderInit();
flxbtwn();
smoothScroll();
jpostal();
gNavPd();
mySwiper();


$(window).on('load scroll', function(){
  fadeIn_pageTopBtn();
  scrollFunc();
});



  objectFitImages('img.ofi');
}(jQuery));
