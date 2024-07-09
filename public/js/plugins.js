function urlSegment(index) {
    var href = $(window).attr("href");
    // window.alert(href.substr(href.lastIndexOf('/') + 1));
    return href.substr(href.lastIndexOf('/') + 1);
}

function camelCase(input) {
    return input.toLowerCase().replace(/-(.)/g, function(match, group1) {
        return group1.toUpperCase();
    });
}
/**
 * Add zeroes before value
 * @param  {int}
 * @param  {int}
 * @return {int}
 */
function zeroFill(number, width) {
    width -= number.toString().length;
    if (width > 0) {
        return new Array(width + (/\./.test(number) ? 2 : 1)).join('0') + number;
    }
    return number + ""; // always return a string
}

/*Checkbox for same as address*/

$('#sameAsBillingAddress').click(function(){
    if ($(this).is(":checked"))
    {
        var shipping = $('#registerShippingAddress').val();

        $('#registerBillingAddress').val(shipping);

        console.info(shipping);

        console.info($('#registerBillingAddress').val());
    }
})


/*Mobile sidebar menu*/
$(document).on("pageinit", ".main", function() {

  $.mobile.ajaxEnabled = false;

  $(document).on("swipeleft swiperight", ".main", function(e) {
      var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
      // We check if there is no open panel on the page because otherwise
      // a swipe to close the left panel would also open the right panel (and v.v.).
      // We do this by checking the data that the framework stores on the page element (panel: open).
      if ($.mobile.activePage.jqmData("panel") !== "open") {
          if (e.type === "swiperight") {
              if (w <= 480) $("#left-panel").panel("open");
          }
      }
  });
});


/*Main*/
$(document).ready(function() {
    
$('.bxslider').bxSlider({
  minSlides: 8,
  maxSlides: 8,
  moveSlides:1,    
  slideWidth: 108,
  slideMargin: 8,
  pager: false
});  

$("#img_01").elevateZoom({
    gallery:'gal1', 
    cursor: 'pointer', 
    galleryActiveClass: 'active', 
    imageCrossfade: true, 
    loadingIcon: 'public/images/spinner.gif',
    responsive: true,
    zoomWindowOffetx:0
    });    
    
$("#img_02").elevateZoom({
    gallery:'gal2', 
    cursor: 'pointer', 
    galleryActiveClass: 'active', 
    imageCrossfade: true, 
    loadingIcon: 'public/images/spinner.gif',
    responsive: true,
    zoomWindowOffetx:0
    });    

$('.panel-title').click(function(){
    $('.panel-title').removeClass('active');
    $(this).addClass('active');
});    
    
//
//$(".order-click").each(
//  function (index) {
//    var $this = $(this);
//    $this.data("index", index);
//    $this.bind("click", function(e) {
//      var $this = $(this);
//      var linkIndex = $this.data("index");
//      $(".order-toggle").each(
//        function (index) {
//          if (index == linkIndex) {              
//            $(this).fadeToggle('fast');                 
//          } else {
//            $(this).hide();
//          }
//        }
//      );
//    });
//  }
//);
    
});